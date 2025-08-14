<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::with('media')->get()->map(function ($event) {
            // dd($event->getFirstMediaUrl('events'));
            // 'user_id',
            // 'name',
            // 'description',
            // 'location',
            // 'date',
            // 'time',
            // 'ticket_url',
            // 'ticket_price',
            return [
                'id'       => $event->id,
                'title'    => $event->name,
                'date'     => $event->date->toDateString(),
                'location'    => $event->location,
                'category' => $event->category ?? 'Uncategorized',
                'image'     => $event->getFirstMediaUrl('events'),
                'ticket_url' => $event->ticket_url,
            ];
        });

        return Inertia::render('Home', [
            'events' => $events
        ]);
    }
}
