<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PostController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\MerchController;

class SubmissionController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        $category = $request->input('category');

        switch ($category) {
            case 'Event':
                return app(EventController::class)->store($request);
            case 'Post':
                return app(PostController::class)->store($request);
            default:
                return redirect()->back()->withErrors(['category' => 'Invalid category selected']);
        }
    }
}
