<?php

namespace Database\Seeders;

use App\Models\Satkers;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        Satkers::create([
            'name'        => 'Pengadilan Tinggi Agama Palu',
            'description' => '-',
            'created_at'  => $now,
            'updated_at'  => $now
        ]);
    }
}
