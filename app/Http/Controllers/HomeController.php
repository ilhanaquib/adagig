<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::all();
        $users = User::role('Admin')->with('Roles')->get();

        return Inertia::render('AdagigPages/Home', [
            'events' => $events,
            'users' => $users
        ]);
    }

    public function show($id)
    {

        return $id;
        // $event = Event::where('id', $id);

        // return Inertia::render('ShowEvent', [
        //     'event' => $event
        // ]);
    }

    public function addEvent()
    {
        return Inertia::render('AdagigPages/AddEventForm');
    }

    public function submitEvent(Request $request)
    {
        // Define validation rules
        $rules = [
            'name' => ['required', 'string', 'max:50'],
            // 'poster' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'date' => ['required', 'date'], // 'date' is now in a valid format
            'location.address' => ['required', 'string', 'max:255'],
            'location.lat' => ['required', 'numeric'],
            'location.lng' => ['required', 'numeric'],
            'description' => ['required', 'string', 'max:255'],
            'link_to_post' => ['required', 'url', 'max:255'],
            'link_to_ticket' => ['required', 'url', 'max:255'],
        ];

        // Create the validator instance
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(), // Validation errors
                'form_data' => $request->all(),   // Return original form data
            ], 422);
        }

        // If validation passes, return the validated data
        $validated = $validator->validated();

        return response()->json([
            'success' => true,
            'message' => 'Validation passed successfully!',
            'data' => $validated, // Return the validated and formatted data
        ], 201);
    }




    public function map()
    {
        return Inertia::render('AdagigPages/Map');
    }
}
