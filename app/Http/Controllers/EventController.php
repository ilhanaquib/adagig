<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::with('media')->get()->map(function ($event) {
            // dd($event->getFirstMediaUrl('events'));
            return [
                'id' => $event->id,
                'title'    => $event->name,
                'date'     => $event->date->toDateString(),
                'venue'    => $event->location,
                'category' => $event->category ?? 'Uncategorized',
                'image'     => $event->getFirstMediaUrl('events')
            ];
        });

        return Inertia::render('Events', [
            'events' => $events
        ]);
    }

    // Show the form for creating a new event
    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'eventName' => 'required|string|max:255',
            'eventDescription' => 'nullable|string',
            'eventLocation' => 'required|string|max:255',
            'eventDate' => 'required|date',
            'eventTime' => 'nullable|date_format:H:i',
            'eventTicketUrl' => 'nullable|url',
            'eventTicketPrice' => 'nullable|numeric|min:0',
            'eventImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // max 5MB
        ]);

        $event = Event::create([
            'user_id' => Auth::user()->id,
            'name' => $validated['eventName'],
            'description' => $validated['eventDescription'] ?? null,
            'location' => $validated['eventLocation'],
            'date' => $validated['eventDate'],
            'time' => $validated['eventTime'] ?? null,
            'ticket_url' => $validated['eventTicketUrl'] ?? null,
            'ticket_price' => $validated['eventTicketPrice'] ?? 0,
        ]);

        if ($request->hasFile('eventImage')) {
            $event->addMediaFromRequest('eventImage')->toMediaCollection('events');
        }

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully!');
    }

    // Display the specified event
    public function show($id)
    {
        $event = Event::with('media')->findOrFail($id);

        return inertia('EventShow', [
            'event' => [
                'id'         => $event->id,
                'title'       => $event->name,
                'date'        => $event->date,
                'venue'       => $event->location,
                'category'    => $event->category ?? 'Uncategorized',
                'image'       => $event->getFirstMediaUrl('events'),
                'description' => $event->description,
                'ticket_url'  => $event->ticket_url,
                'ticket_price' => $event->ticket_price,
            ]
        ]);
    }

    // Show the form for editing the specified event
    public function edit($id)
    {
        $event = Event::findOrFail($id);

        return view('events.edit', compact('event'));
    }

    // Update the specified event in storage
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'venue' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('event_images', 'public');
            $validated['image'] = $path;
            // Optional: delete old image file here
        }

        $event->update($validated);

        return redirect()->route('events.show', $event->id)->with('success', 'Event updated successfully.');
    }

    // Remove the specified event from storage
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        // Optional: delete event image file here

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
