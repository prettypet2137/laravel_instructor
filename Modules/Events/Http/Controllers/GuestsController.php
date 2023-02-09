<?php

namespace Modules\Events\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Events\Entities\Event;
use Modules\Events\Entities\Guest;
use Modules\Events\Jobs\GuestEmailForEventJob;
use Yajra\Datatables\Datatables;
use Modules\Events\Jobs\CourseRescheduled;
use Modules\Events\Jobs\GuestGreetingJob;

class GuestsController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::where('user_id', $request->user()->id)->where('end_date','>=',date('Y-m-d H:i:s'))->get();
        return view('events::guests.datatable', ['events' => $events]);
    }

    public function data(Request $request)
    {
        $user = \Auth::getUser();

        $data = Guest::with('event')->with('sub_guests')->select('event_guests.*');
        $data->where('event_guests.user_id', '=', $user->id);


        if ($request->filled('event')) {
            $data->whereHas('event', function ($query) use ($request) {
                $query->where('name', $request->event);
            });
        }

        if ($request->filled('search')) {
            $search = $request->input('search');

            $data->where(function ($query) use ($search) {
                $query->where('email', 'like', '%' . $search['value'] . '%');
                $query->orWhereHas('event', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search['value'] . '%');
                });
            });
        }

        return Datatables::of($data)
            ->editColumn('event_name', function ($item) {
                return "<a href=" . route('events.edit', ['id' => $item->event->id]) . ">" . $item->event->name . "</a>";
            })
            ->editColumn('ticket', function ($item) {
                if ($item->ticket_name && $item->ticket_price)
                    return $item->ticket_name . " - " . $item->ticket_price . ' ' . ($item->ticket_currency ?? '');
                else return "";
            })
            ->editColumn('action', function ($item) {
                $html = '<a href="javascript:void(0);" data-guest-id="' . $item->id . '" data-event-id="' . $item->event_id . '" class="btn btn-sm btn-secondary btn-transfer mr-1">' . __('Transfer') . '</a>';
                $html .= '<a href="javascript:void(0);" data-id="' . $item->id . '" class="btn btn-sm btn-primary btn-detail mr-1">' . __('Detail') . '</a>';
                $html .= '<a href="javascript:void(0);" data-rowid="' . $item->id . '" class="btn btn-sm btn-danger btn-delete">' . __('Delete') . '</a>';
                return $html;
            })
            ->editColumn('is_paid', function ($item) {
                $html = '<span class="text-danger switch-paid" data-id="' . $item->id . '"><i class="far fa-money-bill-alt"></i> ' . __('Unpaid') . '</span>';
                if ($item->is_paid) $html = '<span class="text-success switch-paid" data-id="' . $item->id . '"><i class="far fa-money-bill-alt"></i> ' . __('Paid') . '</span>';
                return $html;
            })
            ->editColumn('gateway', function ($item) {
                return $item->gateway;
            })
            ->editColumn('status', function ($item) {
                $html = '<span class="badge badge-danger switch-status" data-id="' . $item->id . '">' . __('Registered') . '</span>';
                if ($item->status == 'joined') $html = '<span class="badge badge-success switch-status" data-id="' . $item->id . '">' . __('Joined') . '</span>';
                return $html;
            })
            ->editColumn('created_at', function ($item) {
                return date('d-m-Y H:i:s', strtotime($item->created_at));
            })
            ->filter(function ($instance) use ($request) {
                if ($request->filled('event_id')) {
                    $instance->where('event_id', '=', $request->input('event_id'));
                }
            })
            ->rawColumns(['event_name', 'action', 'is_paid', 'status', 'gateway'])
            ->make(true);
    }

    public function delete(Request $request, $id)
    {
        $item = Guest::find($id);
        if ($item) {
            $item->delete();
            return ['success' => true, 'message' => __('Deleted Successfully')];
        }
        return ['success' => false, 'message' => __('Not found ID')];
    }

    public function switch_status(Request $request, $id)
    {
        $item = Guest::find($id);

        if ($item) {
            $newStatus = '';
            switch ($item->status) {
                case 'registered':
                    $newStatus = 'joined';
                    $item->joined_at = \Carbon\Carbon::now();
                    break;
                case 'joined':
                    $newStatus = 'registered';
                    break;
                default:
                    break;
            }

            $item->status = $newStatus;
            $item->save();

            $html = '<span class="badge badge-danger switch-status" data-id="' . $item->id . '">' . __('Registered') . '</span>';
            if ($item->status == 'joined') {
                $html = '<span class="badge badge-success switch-status" data-id="' . $item->id . '">' . __('Joined') . '</span>';
            }

            return [
                'success' => true,
                'message' => __('Updated Successfully'),
                'html' => $html
            ];
        } else {
            return ['success' => false, 'message' => __('Not found ID')];
        }
    }

    public function switch_paid(Request $request, $id)
    {
        $item = Guest::find($id);

        if ($item) {
            $item->is_paid = !$item->is_paid;
            $item->save();

            $html = '<span class="text-danger switch-paid" data-id="' . $item->id . '"><i class="far fa-money-bill-alt"></i> ' . __('Unpaid') . '</span>';
            if ($item->is_paid) {
                $html = '<span class="text-success switch-paid" data-id="' . $item->id . '"><i class="far fa-money-bill-alt"></i> ' . __('Paid') . '</span>';
            }

            return [
                'success' => true,
                'message' => __('Updated Successfully'),
                'html' => $html
            ];
        } else {
            return ['success' => false, 'message' => __('Not found ID')];
        }
    }

    public function get_detail(Request $request, $id)
    {
        $item = Guest::with(['event', 'sub_guests', 'upsell_histories.upsell'])->find($id);
        if ($item) {

            $statusHtml = "";
            if ($item->status === "registered") {
                $statusHtml = "<span class='badge badge-danger'>" . __('Registered') . "</span>";
            } else if ($item->status === "joined") {
                $statusHtml = "<span class='badge badge-success'>" . __('Joined') . "</span>";
            }
            $item->status = $statusHtml;
            return [
                'success' => true,
                'item' => $item,
            ];
        } else {
            return ['success' => false, 'message' => __('Not found ID')];
        }
    }

    public function getEvents(Request $request, $id)
    {
        $items = Event::where('user_id', $request->user()->id)->where('id', '!=', $id)->where('end_date','>=',date('Y-m-d H:i:s'))->latest()->get();
        return [
            'success' => true,
            'items' => $items,
        ];
    }

    public function transferGuests(Request $request)
    {
        $request->validate([
            'event_id' => 'required',
            'guest_id' => 'required',
        ]);
        $guest = Guest::findOrFail($request->guest_id);
        $event = Event::withCount('guests')->find($request->event_id);
        $total_sub_guests_nums = 0;
        foreach ($event->guests as $guest) {
            $total_sub_guests_nums += $guest->get_sub_guest_nums();
        }
        if ($event->quantity != -1) {
            $available_seats = $event->quantity - ($event->guests_count + $total_sub_guests_nums);
            $guest_count = $guest->get_sub_guest_nums() + 1;
            if ($available_seats < $guest_count) {
                return redirect()->route('guests.index')->withErrors(["msg" => "There are not enough seats for the event. Available seats are " . $available_seats]);
            } 
        } 
        $guest->event_id = (int)$request->event_id;
        $guest->save();
        CourseRescheduled::dispatch(Guest::find($request->guest_id))->onQueue("guests_emails");
        return redirect()->route('guests.index')->withInput();
    }

    public function getGuestsForEmail(Request $request)
    {
        $events = Event::select('id', 'name')->where('user_id', $request->user()->id)->get();
        $data = Guest::with('event')->select('event_guests.*');

        $data->where('event_guests.user_id', '=', $request->user()->id);

        if ($request->filled('guest')) {
            $search = $request->query('guest');
            $data->where('email', trim(strtolower($search)))->orWhere('fullname', 'like', '%' . $search . '%');
        }

        if ($request->filled('event') && $request->event != "all") {
            $search = $request->query('event');
            $data->whereHas('event', function ($query) use ($search) {
                $query->where('name', $search);
            });
        }

        $guests = $data->paginate(config('events.per_page', 10));

        return view('events::guests.guest-email', [
            'guests' => $guests,
            'events' => $events,
        ]);
    }

    public function sendEmailToGuests(Request $request)
    {
        $guests = Guest::with('event')->whereIn("id", (array)$request->ids)->get();
        $data['subject'] = $request->subject;
        $data['body'] = $request->description;

        foreach ($guests as $key => $guest) {
            GuestEmailForEventJob::dispatch($guest->event, $guest, $data)->onQueue('guests_emails');
        }

        return response()->json(['success' => 'Send email successfully.']);
    }

    public function confirmTicket($id) {
        $guest = Guest::find($id);
        $event = Event::find($guest->event_id);
        GuestGreetingJob::dispatch($event, $guest)->onQueue("guests_emails");
        return response()->json([
            "success" => true
        ]);
    }
}
