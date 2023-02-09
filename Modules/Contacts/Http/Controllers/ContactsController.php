<?php

namespace Modules\Contacts\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Contacts\Entities\Contact;

class ContactsController extends Controller
{
    public function contacts(Request $request)
    {
        $skin = config('app.SITE_LANDING');
        $user = $request->user();
        return view('themes::' . $skin . '.contact', compact('user'));
    }

    public function save_contact(Request $request)
    {
        $rules = [
            'fullname' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'subject' => 'required|max:155',
            'content' => 'required|max:255',
        ];
        
        $secret = config('recaptcha.api_secret_key');
        $site_key = config('recaptcha.api_site_key');
        
        if ($secret && $site_key) {
            $rules['g-recaptcha-response'] = 'recaptcha';
        }

        $request->validate($rules);
        $data = $request->all();
        Contact::create($data);

        return redirect()->back()->with('success', __('Your message was sent'));
    }

    public function index(Request $request)
    {
        $query = Contact::orderBy('is_readed', 'ASC')->orderBy('created_at', 'DESC');
        
        if ($request->filled('search'))
        {
            $keyword = $request->input('search');
            $query = $query->where(function($q) use ($keyword) {
                $q->where('fullname', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('subject', 'like', '%' . $keyword . '%');
            });
        }
        $data = $query->paginate(10);

        return view('contacts::contacts.index', compact('data'));
    }

    public function destroy(Request $request, $id)
    {
        $item = Contact::findOrFail($id);

        $item->delete();
        return redirect()->back()->with('success', __('Deleted successfully'));
    }

    public function ajax_readed(Request $request) 
    {
        $id = $request->input('id');
        if(!isset($id)) {
            abort(422);
        }

        $contact = Contact::findOrFail($id);
        $contact->is_readed = true;
        $contact->save();
    }
}
