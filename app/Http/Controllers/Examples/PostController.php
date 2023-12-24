<?php

namespace App\Http\Controllers\Examples;

use App\Exceptions\Examples\PostSlugInUsedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Examples\{PostCreateRequest, PostUpdateRequest};
use App\Http\Resources\Examples\PostResource;
use App\Models\Examples\ExamplePost;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $input = $request->validate([
            'withComments' => 'nullable|in:true',
        ]);

        $posts = new ExamplePost();

        if (!empty($input['withComments'])) {
            $posts = $posts->with('comments');
        }

        return PostResource::collection($posts->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request): PostResource
    {
        $input = $request->validated();

        $input['slug'] = Str::slug($input['title']);

        $checkExistsSlug = ExamplePost::where('slug', $input['slug'])->first();

        if ($checkExistsSlug) {
            $input['slug'] = $input['slug'] . '-' . Str::random(2);
        }

        $post = ExamplePost::create($input);

        return PostResource::make($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(ExamplePost $post, Request $request): PostResource
    {
        $request->validate(['withComments' => 'nullable|in:true']);

        return PostResource::make($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws PostSlugInUsedException
     */
    public function update(PostUpdateRequest $request, ExamplePost $post): PostResource
    {
        $input = $request->validated();

        $input['slug'] = $input['slug'] ?? Str::slug($input['title']);

        $checkExistsSlug = ExamplePost::where('slug', $input['slug'])->first();

        if ($checkExistsSlug && $checkExistsSlug->id !== $post->id) {
            throw new PostSlugInUsedException();
        }

        $post->update($input);

        return PostResource::make($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamplePost $post): void
    {
        $post->delete();
    }
}
