<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            'Ketua',
            'Wakil Ketua',
            'Hakim Tinggi',
            'Hakim Tinggi',
            'Hakim Tinggi',
            'Hakim Tinggi',
            'Hakim Tinggi',
            'Panitera',
            'Sekretaris',
            'Kepala Bagian Perencanaan Dan Kepegawaian',
            'Kepala Bagian Umum Dan Keuangan',
            'Panitera Muda Hukum',
            'Panitera Muda Banding',
            'Panitera Pengganti',
            'Panitera Pengganti',
            'Panitera Pengganti',
            'Panitera Pengganti',
            'Panitera Pengganti',
            'Panitera Pengganti',
            'Panitera Pengganti',
            'Panitera Pengganti',
            'Panitera Pengganti',
            'Panitera Pengganti',
            'Kepala Sub Bagian Rencana Program Dan Anggaran',
            'Kepala Sub Bagian Tata Usaha Dan Rumah Tangga',
            'Kepala Sub Bagian Kepegawaian Dan Teknologi Informasi',
            'Kepala Sub Bagian Keuangan Dan Pelaporan',
            'Pranata Komputer Ahli Muda, Sekretaris',
            'Arsiparis Muda, Sekretaris',
            'Analis Humas, Sub Bagian Tata Usaha Dan Rumah Tangga',
            'Analis Pengelolaan Keuangan APBN Ahli Muda',
            'Pranata Keuangan APBN Penyelia, Sekretaris',
            'Pranata Kearsipan, Sub Bagian Tata Usaha Dan Rumah Tangga',
            'Analis Perkara Peradilan, Panitera Muda Banding',
            'Analis Perkara Peradilan, Panitera Muda Hukum',
            'Pranata Keuangan APBN Pelaksana Lanjutan/Mahir, Sekretaris',
            'Pranata Komputer Ahli Pertama, Sekretaris',
            'Analis Perencanaan, Evaluasi dan Pelaporan, Sub Bagian Rencana Program Dan Anggaran',
            'Analis Sumber Daya Manusia Aparatur, Sub Bagian Kepegawaian Dan Teknologi Informasi',
            'Pranata Kearsipan, Sub Bagian Tata Usaha Dan Rumah Tangga',
            'Penyusun Laporan Keuangan, Sub Bagian Keuangan Dan Pelaporan',
            'Pengelola Perkara, Panitera Muda Banding',
            'Arsiparis Pelaksana, Sekretaris',
            'Pengelola Kepegawaian, Sub Bagian Kepegawaian Dan Teknologi Informasi',
            'Pengelola Kepegawaian, Sub Bagian Kepegawaian Dan Teknologi Informasi',
            'Pengelola Barang Milik Negara, Sub Bagian Tata Usaha Dan Rumah Tangga',
            'Pengelola Barang Milik Negara, Sub Bagian Keuangan Dan Pelaporan',
        ];

        foreach ($positions as $position) {
            $now = Carbon::now();
            DB::table('positions')->insert([
                'name' => $position,
                'description' => 'Deskripsi jabatan ' . $position,
                'created_at'  => $now,
                'updated_at'  => $now
            ]);
        }
    }
}
