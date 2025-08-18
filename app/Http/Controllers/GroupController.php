<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class GroupController extends Controller
{

    public function create()
    {
        return Inertia::render('CreateGroup');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $category = $request->input('category');

        switch ($category) {
            case 'Band':
                return app(BandController::class)->store($request);
            case 'Organisation':
                return app(OrganisationController::class)->store($request);
            default:
                return redirect()->back()->withErrors(['category' => 'Invalid category selected']);
        }
    }
}
