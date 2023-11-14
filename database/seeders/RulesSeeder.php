<?php

namespace Database\Seeders;

use App\Models\Rules;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $startTime = Carbon::now();
        $startTime->setHour(8);
        $startTime->setMinute(0);
        $startTime->setSecond(0);
        $endTime = Carbon::now();
        $endTime->setHour(17);
        $endTime->setMinute(0);
        $endTime->setSecond(0);

        Rules::create([
            'type'       => 'present_time',
            'tag'        => 's_time',
            'value'      => $startTime->toTimeString(),
            'created_at' => $now,
            'updated_at' => $now
        ]);

        Rules::create([
            'type'       => 'present_time',
            'tag'        => 'e_time',
            'value'      => $endTime->toTimeString(),
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
