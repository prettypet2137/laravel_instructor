<?php

namespace Modules\Email\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Email\Entities\EmailReminderTypes;
use Modules\Email\Entities\EmailTemplate;
class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $reminders = EmailReminderTypes::all();

        return view('email::email.admin.templates.index', [
            "reminders" => $reminders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('email::create');
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
        EmailTemplate::create($data);
        return redirect()->route("email.admin.templates.index", ["tab" => $data["reminder_id"]]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('email::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('email::edit');
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
        EmailTemplate::find($id)->update($data);
        return redirect()->route("email.admin.templates.index", ["tab" => $data["reminder_id"]]);
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
