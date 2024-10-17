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
                'image' => 'https://picsum.photos/seed/' . Str::random(10) . '/400/600',
                'date' => Carbon::now()->subDays(rand(0, 10)),
                'location' => Str::random(10),
                'description' => Str::random(10),
                'link_to_post' => Str::random(10),
                'link_to_ticket' => Str::random(10),
            ]);
        }
    }

}
