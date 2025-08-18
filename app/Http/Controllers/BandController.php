<?php

namespace App\Http\Controllers;

use App\Models\Band;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;


class BandController extends Controller
{

    public function index()
    {
        $bands = Band::with('media')->get()->map(function ($band) {
            return [
                'id' => $band->id,
                'name' => $band->name,
                'genre' => $band->genre ?? 'Uncategorized',
                'description' => $band->description,
                'location' => $band->location,
                'links' => $band->links,
                'logo' => $band->getFirstMediaUrl('Band logo'),
                'wallpaper' => $band->getFirstMediaUrl('Band wallpaper'),
            ];
        });

        return Inertia::render('BandsIndex', [
            'bands' => $bands
        ]);
    }

    public function me()
    {
        $user = Auth::user();
        /** @disregard P1013 Undefined method. */
        $bands = $user->bands()->with('media')->get()->map(function ($band) {
            return [
                'id' => $band->id,
                'name' => $band->name,
                'genre' => $band->genre ?? 'Uncategorized',
                'description' => $band->description,
                'location' => $band->location,
                'links' => $band->links,
                'logo' => $band->getFirstMediaUrl('Band logo'),
                'wallpaper' => $band->getFirstMediaUrl('Band wallpaper'),
            ];
        });

        return Inertia::render('BandsMe', [
            'bands' => $bands,
            'authUser' => [
                'id' => $user->id,
                'username' => $user->username,
            ],
        ]);
    }


    public function show(Band $band)
    {
        /** @disregard P1013 Undefined method. */
        $authUser = auth()->user();

        $isMember = $authUser
            ? $band->users->contains($authUser->id)
            : false;

        return Inertia::render('BandShow', [
            'band' => [
                'id' => $band->id,
                'name' => $band->name,
                'genre' => $band->genre ?? 'Uncategorized',
                'description' => $band->description,
                'location' => $band->location,
                'links' => $band->links,
                'logo' => $band->getFirstMediaUrl('Band logo'),
                'wallpaper' => $band->getFirstMediaUrl('Band wallpaper'),
            ],
            'authUser' => $authUser,
            'isMember' => $isMember,
            'posts' => [], // or fetch related posts
        ]);
    }



    public function store(Request $request)

    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'genre' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'links' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'wallpaper' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'users' => 'array',
            'users.*' => 'exists:users,id',
        ]);

        $band = Band::create([
            'name' => $validated['name'],
            'genre' => $validated['genre'] ?? null,
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'] ?? null,
            'links' => $validated['links'] ?? null,
        ]);

        $users = $validated['users'] ?? [];
        /** @disregard P1013 Undefined method 'id'. */
        $users[] = auth()->id();
        $users = array_unique($users);
        $band->users()->sync($users);

        if ($request->hasFile('logo')) {
            $band->addMediaFromRequest('logo')
                ->toMediaCollection('Band logo');
        }

        if ($request->hasFile('wallpaper')) {
            $band->addMediaFromRequest('wallpaper')
                ->toMediaCollection('Band wallpaper');
        }

        return redirect()
            ->route('band.me')
            ->with('success', 'Band created successfully.');
    }
}
