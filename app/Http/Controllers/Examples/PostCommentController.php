<?php

namespace App\Http\Controllers\Examples;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Examples\CommentManagerRequest;
use App\Http\Resources\Examples\{PostAllCommentResource, PostCommentResource};
use App\Models\Examples\{ExampleComment, ExamplePost};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ExamplePost $post): AnonymousResourceCollection
    {
        return PostCommentResource::collection($post->comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExamplePost $post, CommentManagerRequest $request): PostAllCommentResource
    {
        $input            = $request->validated();
        $input['post_id'] = $post->id;

        $comment = $post->comments()->create($input);

        return PostAllCommentResource::make($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(ExamplePost $post, ExampleComment $comment): PostAllCommentResource
    {
        if ($post->id !== $comment->post_id) {
            throw new NotFoundException('ExampleComment not found in this post [ID ' . $post->id . ']');
        }

        return PostAllCommentResource::make($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExamplePost $post, ExampleComment $comment, CommentManagerRequest $request): PostAllCommentResource
    {
        if ($post->id !== $comment->post_id) {
            throw new NotFoundException('ExampleComment not found in this post [ID ' . $post->id . ']');
        }

        $input = $request->validated();
        $comment->update($input);

        return PostAllCommentResource::make($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamplePost $post, ExampleComment $comment): Response
    {
        if ($post->id !== $comment->post_id) {
            throw new NotFoundException('ExampleComment not found in this post [ID ' . $post->id . ']');
        }

        $comment->delete();

        return response()->noContent();
    }
}
