<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'active' => 1,
                'firstname' => 'Ahmed',
                'surname' => 'Olusesi',
                'email' => 'olusesia@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '08074574512',
                'gender' => 'Male',
                'photo' => 'storage/assets/images/admins/default.jpg',
                'address' => 'Ikeja',
                'admin_type_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ];

        Admin::insert($admins);
    }
}
