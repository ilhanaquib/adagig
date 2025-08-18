<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrganisationController extends Controller
{
    public function index()
    {
        $organisations = Organisation::with('media')->get()->map(function ($organisation) {
            return [
                'id' => $organisation->id,
                'name' => $organisation->name,
                'description' => $organisation->description,
                'location' => $organisation->location,
                'links' => $organisation->links,
                'logo' => $organisation->getFirstMediaUrl('Organisation logo'),
                'wallpaper' => $organisation->getFirstMediaUrl('Organisation wallpaper'),
            ];
        });

        return Inertia::render('OrganisationsIndex', [
            'organisations' => $organisations
        ]);
    }

    public function me()
    {
        $user = Auth::user();
        /** @disregard P1013 Undefined method. */
        $organisations = $user->organisations()->with('media')->get()->map(function ($organisation) {
            return [
                'id' => $organisation->id,
                'name' => $organisation->name,
                'description' => $organisation->description,
                'location' => $organisation->location,
                'links' => $organisation->links,
                'logo' => $organisation->getFirstMediaUrl('Organisation logo'),
                'wallpaper' => $organisation->getFirstMediaUrl('Organisation wallpaper'),
            ];
        });

        return Inertia::render('OrganisationsMe', [
            'organisations' => $organisations,
            'authUser' => [
                'id' => $user->id,
                'username' => $user->username,
            ],
        ]);
    }

    public function show(Organisation $organisation)
    {
        /** @disregard P1013 Undefined method. */
        $authUser = auth()->user();

        // Check if logged-in user is part of this organisation
        $isMember = $authUser
            ? $organisation->users->contains($authUser->id)
            : false;

        return Inertia::render('OrganisationShow', [
            'organisation' => [
                'id' => $organisation->id,
                'name' => $organisation->name,
                'description' => $organisation->description,
                'location' => $organisation->location,
                'links' => $organisation->links,
                'logo' => $organisation->getFirstMediaUrl('Organisation logo'),
                'wallpaper' => $organisation->getFirstMediaUrl('Organisation wallpaper'),
            ],
            'authUser' => $authUser,
            'isMember' => $isMember,
            'posts' => [], // or fetch related posts/events if you want
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'links' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'wallpaper' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'users' => 'array',
            'users.*' => 'exists:users,id',
        ]);

        $organisation = Organisation::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'] ?? null,
            'links' => $validated['links'] ?? null,
        ]);

        $users = $validated['users'] ?? [];
        /** @disregard P1013 Undefined method 'id'. */
        $users[] = auth()->id();
        $users = array_unique($users);
        $organisation->users()->sync($users);

        if ($request->hasFile('logo')) {
            $organisation->addMediaFromRequest('logo')
                ->toMediaCollection('Organisation logo');
        }

        if ($request->hasFile('wallpaper')) {
            $organisation->addMediaFromRequest('wallpaper')
                ->toMediaCollection('Organisation wallpaper');
        }

        return redirect()
            ->route('organisation.me')
            ->with('success', 'Organisation created successfully.');
    }
}
