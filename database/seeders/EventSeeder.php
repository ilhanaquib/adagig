<?php

namespace Database\Seeders;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $numberOfEvents = 10;

        for ($i = 0; $i < $numberOfEvents; $i++) {
            $event = Event::create([
                'name' => Str::random(10),
                'poster' => 'https://picsum.photos/seed/' . Str::random(10) . '/400/600',
                'date' => Carbon::now()->subDays(rand(0, 10)),
                'location' => json_encode([
                    'address' => $faker->address, // Random address from Faker
                    'lat' => $faker->latitude(3.1, 3.2), // Latitude in the range of Kuala Lumpur
                    'lng' => $faker->longitude(101.5, 101.7), // Longitude in the range of Kuala Lumpur
                ]),
                'description' => Str::random(10),
                'link_to_post' => Str::random(10),
                'link_to_ticket' => Str::random(10),
            ]);
        }
    }
}
