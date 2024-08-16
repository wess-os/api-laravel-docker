<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    // method to list all posts
    public function index()
    {
        return response()->json([
            "message"=>"List of all posts", 
            "data" => Post::all()
        ], 200);
    }

    // method to create a new post
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|max:255|unique:posts,title',
            'body' => 'required',
        ]);

        $post = $request->user()->posts()->create($fields);

        return response()->json([
            "message"=>"The post was created", 
            "data" => $post
        ], 201);
    }

    // method to show a post
    public function show(Post $post)
    {
        return response()->json([
            "message"=>"The post was shown", 
            "data" => $post
        ], 200);
    }

    // method to update a post
    public function update(Request $request, Post $post)
    {
        Gate::authorize('modify', $post);

        $fields = $request->validate([
            'title' => 'max:255|required_without:body|unique:posts,title,' . $post->id,
            'body' => 'required_without:title',
        ]);

        if ($request->input('title') === $post->title || $request->input('body') === $post->body) {
            return response()->json([
                'message' => 'No changes detected. Please modify the title or body.'
            ], 422);
        }

        $post->update($fields);

        return response()->json([
            "message"=>"The post was updated", 
            "data" => $post
        ], 200);
    }

    // method to delete a post
    public function destroy(Post $post)
    {
        Gate::authorize('modify', $post);

        $post->delete();

        return response()->json([], 204);
    }
}
