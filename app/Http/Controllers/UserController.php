<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        if ($q === '') {
            return response()->json([]); // nothing typed, nothing returned
        }

        $users = User::query()
            ->select('id', 'username', 'email')
            ->where(function ($qb) use ($q) {
                $qb->where('username', 'like', "{$q}%")
                    ->orWhere('email', 'like', "{$q}%");
            })
            ->orderBy('username')
            ->limit(10)
            ->get();

        return response()->json($users); // raw array
    }
}
