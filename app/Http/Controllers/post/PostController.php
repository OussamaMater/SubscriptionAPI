<?php

namespace App\Http\Controllers\post;

use App\Events\PostPublished;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Website;

class PostController extends Controller
{
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        try {
            $website = Website::findOrFail($validated['website']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response([
                'status' => 'error',
                'error'  => 'website not found.'
            ], 404);
        }

        $post = $website->posts()->create([
            'title'       => $validated['title'],
            'description' => $validated['description']
        ]);

        event(new PostPublished($post));

        return response([
            'status'  => 'created',
            'message' => 'post was created.'
        ], 201);
    }
}
