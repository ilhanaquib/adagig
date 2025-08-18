<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function me()
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $profile = $user->profile ?? new Profile();

        return inertia('Profile', [
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'roles' => $user->getRoleNames(),
            ],
            'profile' => [
                'bio' => $profile->bio,
                'location' => $profile->location,
                'links' => $profile->links,
                'profile_picture' => $profile->getFirstMediaUrl('profile_picture') ?: '/images/default-profile.png',
                'wallpaper' => $profile->getFirstMediaUrl('wallpaper') ?: '/images/default-wallpaper.jpg',
            ],
            'posts' => $user->posts()
                ->latest()
                ->get()
                ->map(fn($post) => [
                    'caption' => $post->caption,
                    'image' => $post->getFirstMediaUrl('posts') ?: '/images/default-post.png',
                ]),

            'bands' => $user->bands()
                ->with('media')
                ->get()
                ->map(fn($band) => [
                    'id' => $band->id,
                    'name' => $band->name,
                    'logo' => $band->getFirstMediaUrl('Band logo') ?: '/images/band-placeholder.png',
                ]),

            'organisations' => $user->organisations()
                ->with('media')
                ->get()
                ->map(fn($org) => [
                    'id' => $org->id,
                    'name' => $org->name,
                    'logo' => $org->getFirstMediaUrl('Organisation logo') ?: '/images/org-placeholder.png',
                ]),

            'authUser' => [
                'id' => $user->id,
                'username' => $user->username,
            ],

            'isFollowing' => false, // can't follow yourself

            'followersCount' => $user->followers()->count(),
            'followingCount' => $user->following()->count(),
        ]);
    }


    public function show(User $user)
    {
        /** @var \App\Models\User $authUser **/
        $profile = $user->profile ?? new Profile();
        $authUser = Auth::user();
        /** @disregard P1013 Undefined method 'following'. */

        return inertia('Profile', [
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'roles' => $user->getRoleNames(),
            ],
            'profile' => [
                'bio' => $profile->bio,
                'location' => $profile->location,
                'links' => $profile->links,
                'profile_picture' => $profile->getFirstMediaUrl('profile_picture') ?: '/images/default-profile.png',
                'wallpaper' => $profile->getFirstMediaUrl('wallpaper') ?: '/images/default-wallpaper.jpg',
            ],
            'posts' => $user->posts()
                ->latest()
                ->get()
                ->map(fn($post) => [
                    'caption' => $post->caption,
                    'image' => $post->getFirstMediaUrl('posts') ?: '/images/default-post.png',
                ]),
            'bands' => $user->bands()
                ->with('media')
                ->get()
                ->map(fn($band) => [
                    'id' => $band->id,
                    'name' => $band->name,
                    'logo' => $band->getFirstMediaUrl('Band logo') ?: '/images/band-placeholder.png',
                ]),

            'organisations' => $user->organisations()
                ->with('media')
                ->get()
                ->map(fn($org) => [
                    'id' => $org->id,
                    'name' => $org->name,
                    'logo' => $org->getFirstMediaUrl('Organisation logo') ?: '/images/org-placeholder.png',
                ]),

            'authUser' => $authUser ? [
                'id' => $authUser->id,
                'username' => $authUser->username,
            ] : null,

            'isFollowing' => $authUser
                ? $authUser->following()->where('followed_id', $user->id)->exists()
                : false,

            // 👇 counts
            'followersCount' => $user->followers()->count(),
            'followingCount' => $user->following()->count(),
        ]);
    }



    public function update(Request $request)
    {

        /** @var \App\Models\User $user **/
        $user = Auth::user();

        // Validation
        $validated = $request->validate([
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'nullable|string|max:255',
            'username'         => 'required|string|max:50|unique:users,username,' . $user->id,
            'bio'              => 'nullable|string|max:500',
            'location'         => 'nullable|string|max:255',
            'link'             => 'nullable|url|max:255',
            'profile_picture'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'wallpaper'        => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        // Update user
        $user->fill([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'] ?? null,
            'username'   => $validated['username'],
        ])->save();

        // Update or create profile
        $profile = $user->profile ?? new Profile();
        $profile->user_id = $user->id;
        $profile->fill([
            'bio'      => $validated['bio'] ?? null,
            'location' => $validated['location'] ?? null,
            'links' => $validated['link'] ? json_encode([$validated['link']]) : null
        ])->save();

        // Handle file uploads
        if ($request->hasFile('profile_picture')) {
            $profile->clearMediaCollection('profile_picture');
            $profile->addMediaFromRequest('profile_picture')
                ->toMediaCollection('profile_picture');
        }

        if ($request->hasFile('wallpaper')) {
            $profile->clearMediaCollection('wallpaper');
            $profile->addMediaFromRequest('wallpaper')
                ->toMediaCollection('wallpaper');
        }

        return back()->with('success', 'Profile updated successfully.');
    }
}
