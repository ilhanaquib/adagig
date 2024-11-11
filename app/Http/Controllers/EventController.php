<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();


        return Inertia::render('AdagigPages/Home', [
            'events' => $events
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

    public function submitEvent()
    {
        //
    }
}
