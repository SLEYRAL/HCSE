<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();
        if($this->checkUserCommentExist($validatedData['profile_id']) !== null){
            return response('error: you have already comment this profile', Response::HTTP_FORBIDDEN);
        }
        $data = Comment::create($validatedData);
        return response($data, Response::HTTP_CREATED);
    }

    /**
     * @param $profile_id
     * @return mixed
     */
    public function checkUserCommentExist($profile_id)
    {
        return Comment::where('user_id', '=', Auth::id())
            ->where('profile_id', '=', $profile_id)->first();
    }
}
