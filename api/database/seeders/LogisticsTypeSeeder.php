<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LogisticsType;

class LogisticsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $logisticsType = [
            [
                'types' => 'Dispatch',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'types' => 'Transport',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ];

        LogisticsType::insert($logisticsType);
    }
}
