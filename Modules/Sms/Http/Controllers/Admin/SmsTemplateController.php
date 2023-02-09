<?php

namespace Modules\Sms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Twilio\Rest\Client;
use Modules\Sms\Entities\SmsReminderTypes;
use Modules\Sms\Entities\SmsTemplate;
use Modules\Sms\Entities\SmsAccount;


class SmsTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $reminders = SmsReminderTypes::all();
        return view('sms::sms.admin.templates.index', array(
            "reminders" => $reminders
        ));
    }

    public function show($id) {
        $data = SmsTemplate::find($id);
        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "subject" => "required",
            "description" => "required"
        ]);
        $data = $request->except("_token");
        $isExist = SmsTemplate::where([
            "reminder_id" => $data["reminder_id"],
            "user_id" => $data["user_id"]
        ])->count();
        if ($isExist) {
            return redirect()->route('sms.admin.templates.index', ["tab" => $data['reminder_id']])->withErrors(['msg' => 'The template associated with the reminder already exist.']);
        } else {
            SmsTemplate::create($data);
            return redirect()->route("sms.admin.templates.index", ["tab" => $data["reminder_id"]]);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "subject" => "required",
            "description" => "required"
        ]);
        $data = $request->except(["_token", "_method"]);
        SmsTemplate::find($id)->update($data);
        return redirect()->route("sms.admin.templates.index", ["tab" => $data["reminder_id"]]);
    }

    public function testSms(Request $request) {
        try {
            $data = $request->except("_token");
            $receiverNumber = $data["receiver_number"];
            $template = SmsTemplate::find($data["template_id"]);
            $account = SmsAccount::first();
            $client = new Client($account->twilio_sid, $account->twilio_token);
            $client->messages->create($receiverNumber, [
                "from" => $account->twilio_number,
                "body" => $template->subject . "\n\r" . $template->description
            ]);
            return response()->json([
                "message" => "You sent SMS to " . $receiverNumber . " successfully."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
