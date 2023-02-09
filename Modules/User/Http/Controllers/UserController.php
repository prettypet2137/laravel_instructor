<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\Events\Entities\AboutUser;
use Modules\Saas\Entities\Package;
use Modules\User\Entities\User;
use Modules\User\Jobs\UserEmailJob;
use Modules\User\Mail\UserEmail;
use Nwidart\Modules\Facades\Module;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::query();

        if ($request->filled('search')) {
            $data->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $data = $data->paginate(10);

        return view('user::users.index', compact(
            'data'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = [];

        if (Module::find('Saas')) {
            $packages = Package::all();
        }

        return view('user::users.create', compact(
            'packages'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6|same:password_confirmation',
            'package_ends_at' => 'nullable|date',
        ]);

        $user = DB::table('users')
            ->whereRaw('TRIM(LOWER(name)) = ? ', trim(strtolower($request->name)))
            ->count();

        if ($user) {
            $request->merge([
                'name' => $request->name . substr(time(), 7, 3)
            ]);
        }

        $request->request->add([
            'password' => Hash::make($request->password),
        ]);


        $user = User::create($request->all());

        return redirect()->route('settings.users.index')
            ->with('success', __('Created successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        $packages = [];
        if (Module::find('Saas')) {
            $packages = Package::all();
        }
        return view('user::users.edit', compact(
            'user',
            'packages'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'role' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|same:password_confirmation',
            'package_ends_at' => 'nullable|date',

        ]);

        // $user = DB::table('users')
        //     ->whereRaw('TRIM(LOWER(name)) = ? ', trim(strtolower($request->name)))
        //     ->count();

        // if ($user) {
        //     $request->merge([
        //         'name' => $request->name . substr(time(), 7, 3)
        //     ]);
        // }

        if ($request->filled('password')) {
            $request->request->add([
                'password' => Hash::make($request->password),
            ]);
        } else {
            $request->request->remove('password');
            $request->request->remove('password_confirmation');
        }

         $data=$request->all();
        
        unset($data['_token']);
        unset($data['_method']);
         unset($data['password_confirmation']);
      
         User::where('id',$user->id)->update($data);
        // $user->update($request->all());

        return redirect()->route('settings.users.edit', $user)
            ->with('success', __('Updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if ($request->user()->id == $user->id) {
            return redirect()->route('settings.users.index')
                ->with('error', __("You can't remove yourself."));
        }
        // if ($user->resumecvs()->count() > 0) {
        //     return redirect()->back()->with('error',"Can't delete because it has resumecvs in it");
        // }

        $user->delete();

        return redirect()->route('settings.users.index')
            ->with('success', __('Deleted successfully'));
    }

    public function accountSettings(Request $request)
    {
        $user = $request->user();
        $about = AboutUser::where('user_id', auth()->user()->id)->first();
        if (!empty($about)) {
            $about['description'] = unserialize($about->description);
        }
        return view('user::auth.profile', compact(
            'user', 'about'
        ));
    }

    public function accountSettingsUpdate(Request $request)
    {
        $request->validate([
            'company' => 'nullable|max:255',
            'password' => 'same:password_confirmation',
        ]);

        if ($request->filled('password')) {
            $request->request->add([
                'password' => Hash::make($request->password),
            ]);
            $userData['password'] = $request->password;
        } else {
            $request->request->remove('password');
        }

        $user = auth()->user();

        if (isset($request->description)) {
            $about = AboutUser::where('user_id', $user->id)->first();
            if (is_null($about)) {
                AboutUser::create([
                    "user_id" => $user->id,
                    "description" => serialize($request->description)
                ]);
            } else {
                $about->update([
                    'user_id' => $user->id,
                    'description' => serialize($request->description)
                ]);
            }
        }

        $userData['company'] = $request->company;


        $userData['settings'] = $request->settings;

        $request->user()->update($userData);

        return redirect()->route('accountsettings.index')
            ->with('success', __('Updated successfully'));
    }

    public function impersonate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        \Auth::user()->impersonate($user);

        return redirect()->route('dashboard')->with('success', __('Impersonate successfully'));
    }

    public function leaveimpersonate(Request $request)
    {
        $manager = app('impersonate');
        if (!$manager->isImpersonating()) {
            abort(404);
        }

        \Auth::user()->leaveImpersonation();

        return redirect()->route('settings.users.index')->with('success', __('Leave impersonate successfully'));
    }

    public function getUsersForEmail(Request $request)
    {
        $data = User::query();

        if ($request->filled('query')) {
            $data->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', $request->search);
        }

        $data = $data->paginate(10);

        return view('user::users.user-email', compact(
            'data'
        ));
    }

    public function sendEmailToUsers(Request $request)
    {
        $users = User::query();
        if ($request->is_all) {
            $users = $users->get();
        } else {
            $users = $users->whereIn("id", (array)$request->ids)->get();
        }

        $data['subject'] = $request->subject;
        $data['body'] = $request->description;

        foreach ($users as $key => $user) {
            UserEmailJob::dispatch($user, $data)->onQueue('users_emails');
        }
        return response()->json(['success' => 'Send email successfully.']);
    }
}
