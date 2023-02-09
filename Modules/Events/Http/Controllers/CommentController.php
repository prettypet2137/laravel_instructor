<?php

namespace Modules\Events\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Events\Entities\Comment;
use Modules\Events\Jobs\CommentEmailJob;
use Modules\User\Entities\User;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $comments = Comment::query()->where('user_id', $request->user()->id);
        $query = $request->input('search');
        if (!empty($query)) {
            $comments->where('name', 'like', '%' . $query . '%')->orWhere('email', $query)->orWhere('description', 'like', '%' . $query . '%');
        }
        $comments = $comments->paginate(config('events.per_page', 10));
        return view('events::comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('events::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $user = User::where('id', (int)$request->user_id)->first();
        if (empty($user)) {
            return redirect()->back()->with('error', 'Events owner is invalid.');
        }
        $attributes = $request->validate([
            'user_id' => 'required|numeric',
            'name' => 'required',
            'email' => 'required|email',
            'description' => 'required',
        ]);
        Comment::create($attributes);
        $data['name'] = $attributes['name'];
        $data['email'] = $attributes['email'];
        $data['subject'] = 'Comment / FAQs';
        $data['body'] = $attributes['description'];
        CommentEmailJob::dispatch($user,$data)->onQueue('comments_emails');
        return redirect()->route('all-events.index', ['name' => getSlugName($user->name)])->with('success', 'Successfully submitted');
    }
}
