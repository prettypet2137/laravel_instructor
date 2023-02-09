<?php

namespace Modules\Sms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Sms\Entities\SmsAccount;
use Modules\Sms\Entities\SmsHire;



class SmsSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $smsAccount = SmsAccount::first();
        $smsHires = SmsHire::all();
        return view('sms::sms.admin.setting.index', [
            "sms_account" => $smsAccount,
            "sms_hires" => $smsHires
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "twilio_sid" => "required",
            "twilio_token" => "required",
            "twilio_number" => "required"
        ]);
        $data = $request->except("_token");
        SmsAccount::create($data);
        return redirect()->route("sms.admin.setting.index");

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('sms::edit');
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
            "twilio_sid" => "required",
            "twilio_token" => "required",
            "twilio_number" => "required"
        ]);
        $account = $request->except(["_token", "_method"]);
        SmsAccount::find($id)->update($account);
        return redirect()->route("sms.admin.setting.index");
    }

    public function feeUpdate(Request $request) {
        $request->validate([
            "sms_fee" => "required"
        ]);
        $data = $request->except(["_token", "_method"]);
        $smsAccount = SmsAccount::first();
        if (is_null($smsAccount)) {
            return redirect()->route('sms.admin.setting.index')->withErrors([
                "msg" => "You need to save SMS account before setting the fee."
            ]);
        } else {
            $smsAccount->update($data);
            return redirect()->route('sms.admin.setting.index')->with([
                "success" => "Saved success !"
            ]);
        }
    }

    public function hireStore(Request $request) {
        $request->validate([
            "amount" => "required"
        ]);
        $data = $request->except("_token");
        SmsHire::create($data);
        return redirect()->route("sms.admin.setting.index");
    }

    public function hireEnable(Request $request, $id) {
        $data = $request->except(["_token", "_method"]);
        SmsHire::where("id", "<>", $id)->update([
            "is_active" => 0
        ]);
        SmsHire::find($id)->update($data);
        return redirect()->route("sms.admin.setting.index");
    }

    public function hireShow($id) {
        $data = SmsHire::find($id);
        return response()->json($data);
    }
    public function hireUpdate(Request $request, $id) {
        $request->validate([
            "amount" => "required"
        ]);
        $data = $request->except(["_token", "_method"]);
        SmsHire::find($id)->update($data);
        return redirect()->route("sms.admin.setting.index");
    }

    public function hireDestroy($id) {
        SmsHire::find($id)->delete();
        return redirect()->route('sms.admin.setting.index');
    }
}
