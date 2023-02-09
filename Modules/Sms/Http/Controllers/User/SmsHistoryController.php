<?php

namespace Modules\Sms\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Sms\Entities\SmsHistories;

class SmsHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $histories = SmsHistories::all();
        return view('sms::sms.user.history.index', ["histories" => $histories]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('sms::show');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        SmsHistories::find($id)->delete();
        return redirect()->route("sms.user.histories.index");   
    }
}
