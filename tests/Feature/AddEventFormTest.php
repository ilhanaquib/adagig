<?php

use App\Models\Event;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

it('creates an event when valid data is provided', function () {
    // Fake the file system for testing
    Storage::fake('public');

    // Prepare valid data for the event
    $data = [
        'name' => 'Test Event',
        'poster' => UploadedFile::fake()->image('poster.jpg'), // Fake an image file upload
        'date' => '2024-12-01',
        'location' => [
            'address' => '123 Event St',
            'lat' => 12.34,
            'lng' => 56.78
        ],
        'description' => 'This is a test event.',
        'link_to_post' => 'https://example.com/post',
        'link_to_ticket' => 'https://example.com/ticket',
    ];

    // Make the POST request to the submitEvent route
    $response = $this->postJson(route('event.submit'), $data);

    // Assert that the event was created in the database
    $this->assertDatabaseHas('events', [
        'name' => $data['name'],
        'date' => $data['date'],
        'description' => $data['description'],
        'link_to_post' => $data['link_to_post'],
        'link_to_ticket' => $data['link_to_ticket'],
    ]);

    // Assert that the poster image is stored in the correct directory
    Storage::disk('public')->assertExists('posters/' . $data['poster']->hashName());

    // Assert that the response is correct
    $response->assertStatus(201)
    ->assertJson([
            'message' => 'Event created successfully!'
        ]);
});

it('returns a validation error when data is invalid', function () {
    // Prepare invalid data (missing required fields)
    $data = [
        'name' => '',
        'poster' => null,
        'date' => 'invalid-date',
        'location' => [
            'address' => '',
            'lat' => '',
            'lng' => '',
        ],
        'description' => '',
        'link_to_post' => 'invalid-url',
        'link_to_ticket' => 'invalid-url',
    ];

    // Make the POST request to the submitEvent route
    $response = $this->postJson(route('event.submit'), $data);

    // Assert that the response status is 422 (Unprocessable Entity) due to validation errors
    $response->assertStatus(422);

    // Assert that the response contains the correct validation errors
    $response->assertJsonValidationErrors(['name', 'poster', 'date', 'location.address', 'location.lat', 'location.lng', 'description', 'link_to_post', 'link_to_ticket']);
});
