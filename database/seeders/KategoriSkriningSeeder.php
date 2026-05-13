<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSkriningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'nama_kategori' => 'Skrining TBC Anak', 'min_age' => 0, 'max_age' => 14, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 2, 'nama_kategori' => 'Skrining TBC Dewasa', 'min_age' => 15, 'max_age' => 250, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        foreach (array_chunk($data, 500) as $chunk) {
            DB::table('master_kategori_skrinings')->insert($chunk);
        }
    }
}
