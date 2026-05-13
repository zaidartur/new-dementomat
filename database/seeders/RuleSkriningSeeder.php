<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RuleSkriningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // anak
            ['uid_rule' => Str::uuid(), 'kategori_id' => 1, 'nama_aturan' => 'Anak Wajib Rujuk - Kontak & Batuk', 'rekomendasi' => 'Wajib Menghubungi Kader / Petugas Puskesmas', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_rule' => Str::uuid(), 'kategori_id' => 1, 'nama_aturan' => 'Anak Wajib Rujuk - Batuk & Demam', 'rekomendasi' => 'Wajib Menghubungi Kader / Petugas Puskesmas', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_rule' => Str::uuid(), 'kategori_id' => 1, 'nama_aturan' => 'Anak Wajib Rujuk - Batuk & BB Turun', 'rekomendasi' => 'Wajib Menghubungi Kader / Petugas Puskesmas', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_rule' => Str::uuid(), 'kategori_id' => 1, 'nama_aturan' => 'Anak Wajib Rujuk - Kontak & BB Turun', 'rekomendasi' => 'Wajib Menghubungi Kader / Petugas Puskesmas', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

            // dewasa
            ['uid_rule' => Str::uuid(), 'kategori_id' => 2, 'nama_aturan' => 'Dewasa Wajib Rujuk - Batuk lama', 'rekomendasi' => 'Wajib Menghubungi Kader / Petugas Puskesmas', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_rule' => Str::uuid(), 'kategori_id' => 2, 'nama_aturan' => 'Dewasa Wajib Rujuk - Batuk / dahak bercampur darah', 'rekomendasi' => 'Wajib Menghubungi Kader / Petugas Puskesmas', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        foreach (array_chunk($data, 500) as $chunk) {
            DB::table('data_rule_skrinings')->insert($chunk);
        }
    }
}
