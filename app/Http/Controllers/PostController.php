<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function store(Request $request)
    {
        // dd('post controlle reached', $request->all());
        // Validate and store the new post
        $validated = $request->validate([
            'caption' => 'required|string',
            'postImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // Logic to save the post
        $post = Post::create([
            'user_id' => Auth::user()->id,
            'caption' => $validated['caption'],
        ]);

        if ($request->hasFile('postImage')) {
            $post->addMediaFromRequest('postImage')->toMediaCollection('posts');
        }

        return redirect()->route('profile.show')->with('success', 'Post created successfully!');
    }
}
