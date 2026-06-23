<?php

namespace Database\Seeders;

use App\Models\StatusKeluarga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kode'  => '02', 'nama' => 'Suami'],
            ['kode'  => '03', 'nama' => 'Istri'],
            ['kode'  => '04', 'nama' => 'Anak'],
            ['kode'  => '05', 'nama' => 'Menantu'],
            ['kode'  => '06', 'nama' => 'Cucu'],
            ['kode'  => '07', 'nama' => 'Orang Tua'],
            ['kode'  => '08', 'nama' => 'Mertua'],
            ['kode'  => '09', 'nama' => 'Famili Lainnya'],
            ['kode'  => '10', 'nama' => 'Pembantu'],
            ['kode'  => '11', 'nama' => 'Lainnya'],
        ];

        foreach ($data as $key => $value) {
            StatusKeluarga::firstOrCreate($value);
        }
    }
}
