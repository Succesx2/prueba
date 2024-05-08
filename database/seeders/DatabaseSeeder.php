<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //User::factory()->create([
          //  'name' => 'Test User',
           // 'email' => 'test@example.com',
        //]);

        $country = Country::create(['name'=> "Colombia"
        ]);

        $country->save();

        $country = Country::create(['name'=> "Peru"
        ]);

        $country->save();

        $country = Country::create(['name'=> "Ecuador"
        ]);

        $country->save();

        $country = Country::create(['name'=> "Argentina"
        ]);

        $country->save();

        $country = Country::create(['name'=> "Chile"
        ]);

        $country->save();

        $country = Country::create(['name'=> "Venezuela"
        ]);

        $country->save();
    }
}
