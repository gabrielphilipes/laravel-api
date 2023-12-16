<?php

namespace App\Http\Controllers\Examples;

use App\Exceptions\Examples\PostSlugInUsedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Examples\{PostCreateRequest, PostUpdateRequest};
use App\Http\Resources\Examples\PostResource;
use App\Models\Examples\Post;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return PostResource::collection(Post::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request): PostResource
    {
        $input = $request->validated();

        $input['slug'] = Str::slug($input['title']);

        $checkExistsSlug = Post::where('slug', $input['slug'])->first();

        if ($checkExistsSlug) {
            $input['slug'] = $input['slug'] . '-' . Str::random(2);
        }

        $post = Post::create($input);

        return PostResource::make($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): PostResource
    {
        return PostResource::make($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostUpdateRequest $request
     * @param Post $post
     * @return PostResource
     * @throws PostSlugInUsedException
     */
    public function update(PostUpdateRequest $request, Post $post): PostResource
    {
        $input = $request->validated();

        $input['slug'] = $input['slug'] ?? Str::slug($input['title']);

        $checkExistsSlug = Post::where('slug', $input['slug'])->first();

        if ($checkExistsSlug && $checkExistsSlug->id !== $post->id) {
            throw new PostSlugInUsedException();
        }

        $post->update($input);

        return PostResource::make($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): void
    {
        $post->delete();
    }
}
