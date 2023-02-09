<?php

namespace Modules\Reports\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Events\Entities\Event;
use Modules\Events\Entities\Guest;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $events = Event::where("user_id", auth()->id())->get();
        // $coursesRegisterAndSales = Event::withCount('guests as registered')->withSum('guests as sales', 'ticket_price')->where('user_id', auth()->id())->where('created_at', '<=', Carbon::today())->latest()->get();
        $coursesRegisterAndSales = [];
        foreach ($events as $event) {
            $guests = Guest::where(["event_id" => $event->id, "is_paid" => 1])->get();
            $total_ticket_price = 0;
            $total_cnt_guests = count($guests);
            $total_sale_price= 0;
            foreach ($guests as $guest) {
                foreach ($guest->upsell_histories as $upsell_history) {
                    $total_sale_price += is_null($upsell_history->price) ? 0 : (float) $upsell_history->price;
                }

                $total_ticket_price += (float) $guest->ticket_price * ((float) $guest->sub_guests->count() + 1);
                $total_cnt_guests += $guest->sub_guests->count();
            }       
            $coursesRegisterAndSale = $event->toArray();
            $coursesRegisterAndSale["registered"] = $total_cnt_guests;
            $coursesRegisterAndSale["sales"] = $total_ticket_price;
            $coursesRegisterAndSale["upsell_sales"] = $total_sale_price;
            $coursesRegisterAndSales[] = $coursesRegisterAndSale;
        }

        // $last30DaysProfit = Guest::where('user_id', auth()->id())->where('created_at', '>=', Carbon::today()->subDays(30))->sum('ticket_price');
        $last30DaysProfit = 0;
        $guests = Guest::where(["user_id" => auth()->id(), "is_paid" => 1])->where("created_at", ">=", Carbon::today()->subDays(30))->get();
        foreach ($guests as $guest) {
            $last30DaysProfit += $guest->ticket_price * ($guest->sub_guests->count() + 1);
            foreach ($guest->upsell_histories as $upsell_history) {
                $last30DaysProfit += is_null($upsell_history->price) ? 0 : (float) $upsell_history->price;
            }
        }
        $coursesSalesMonthly = [];
        for ($month = 1; $month <= 12; $month++) {
            $date = Carbon::create(date('Y'), $month);
            $date_end = $date->copy()->endOfMonth();
            // $guestPrice = Guest::where('user_id', auth()->id())->where('created_at', '>=', $date)->where('created_at', '<=', $date_end)->sum('ticket_price');
            $guestPrice = 0;
            $upsellPrice = 0;
            $guests = Guest::where("user_id", auth()->id())->where("is_paid", 1)->where("created_at", ">=", $date)->where("created_at", "<=", $date_end)->get();
            foreach($guests as $guest) {
                $guestPrice += $guest->ticket_price * ($guest->sub_guests->count() + 1);
                foreach ($guest->upsell_histories as $upsell_history) {
                    $upsellPrice += is_null($upsell_history->price) ? 0 : (float) $upsell_history->price;
                }
            }
            $coursesSalesMonthly[] = [
                'month' => Carbon::create()->month($month)->format('F'),
                'sale' => $guestPrice,
                'upsell_sale' => $upsellPrice
            ];
        }
        return view('reports::index', compact('coursesRegisterAndSales', 'coursesSalesMonthly', 'last30DaysProfit'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('reports::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('reports::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('reports::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
