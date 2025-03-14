<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RiderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create 50 dummy rider records
        for ($i = 0; $i < 50; $i++) {
            DB::table('riders')->insert([
                // Personal Information
                'fullname'                  => $faker->name,
                'phone_number'              => $faker->unique()->phoneNumber,
                'email'                     => $faker->unique()->safeEmail,
                'address'                   => $faker->address,
                'date_of_birth'             => $faker->date('Y-m-d'),
                'profile_photo'             => $faker->optional()->imageUrl(640, 480, 'people'),

                // Vehicle Information
                'vehicle_type'              => $faker->randomElement(['Bike', 'Car', 'Van']),
                'vehicle_number'            => strtoupper($faker->bothify('??###')),
                'vehicle_model'             => $faker->word,
                'vehicle_color'             => $faker->safeColorName,

                // Work Details
                'rider_status'              => 'Active',
                'availability'              => $faker->boolean(80), // 80% chance to be true
                'joining_date'              => $faker->date('Y-m-d'),
                'work_zone'                 => $faker->city,
                'rider_rating'              => $faker->randomFloat(2, 0, 5), // rating between 0 and 5
                'total_deliveries'          => $faker->numberBetween(0, 1000),
                'on_time_delivery_rate'     => $faker->randomFloat(2, 0, 100), // percentage between 0 and 100

                // Additional Metadata
                'notes'                     => $faker->optional()->sentence,
                'emergency_contact_name'    => $faker->name,
                'emergency_contact_phone'   => $faker->phoneNumber,

                // Timestamps
                'created_at'                => now(),
                'updated_at'                => now(),
            ]);
        }
    }
}
