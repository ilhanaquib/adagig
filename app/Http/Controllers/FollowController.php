<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function store(User $user)
    {
        $authUser = Auth::user();

        if ($authUser->id === $user->id) {
            return back()->withErrors('You cannot follow yourself.');
        }
        /** @disregard P1013 Undefined method 'following'. */
        $authUser->following()->syncWithoutDetaching([$user->id]);

        return back();
    }

    public function destroy(User $user)
    {
        $authUser = Auth::user();
        /** @disregard P1013 Undefined method 'following'. */
        $authUser->following()->detach($user->id);

        return back();
    }
}
