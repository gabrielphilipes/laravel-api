<?php

namespace App\Http\Controllers\Examples;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Examples\CommentManagerRequest;
use App\Http\Resources\Examples\PostCommentResource;
use App\Models\Examples\{Comment, Post};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post): AnonymousResourceCollection
    {
        return PostCommentResource::collection($post->comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Post $post, CommentManagerRequest $request): PostCommentResource
    {
        $input            = $request->validated();
        $input['post_id'] = $post->id;

        $comment = $post->comments()->create($input);

        return PostCommentResource::make($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, Comment $comment)
    {
        if ($post->id !== $comment->post_id) {
            throw new NotFoundException('Comment not found in this post [ID ' . $post->id . ']');
        }

        return PostCommentResource::make($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Post $post, Comment $comment, CommentManagerRequest $request)
    {
        if ($post->id !== $comment->post_id) {
            throw new NotFoundException('Comment not found in this post [ID ' . $post->id . ']');
        }

        $input = $request->validated();
        $comment->update($input);

        return PostCommentResource::make($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment)
    {
        if ($post->id !== $comment->post_id) {
            throw new NotFoundException('Comment not found in this post [ID ' . $post->id . ']');
        }

        $comment->delete();

        return response()->noContent();
    }
}
