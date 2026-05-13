<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ParameterSkriningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // dewasa
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 2, 'kode' => 'D1', 'pertanyaan' => 'Batuk lama 1-2 minggu atau lebih (berdahak ataupun kering)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 2, 'kode' => 'D2', 'pertanyaan' => 'Sesak nafas', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 2, 'kode' => 'D3', 'pertanyaan' => 'Batuk / dahak bercampur darah', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 2, 'kode' => 'D4', 'pertanyaan' => 'Nyeri dada saat batuk', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 2, 'kode' => 'D5', 'pertanyaan' => 'Demam', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 2, 'kode' => 'D6', 'pertanyaan' => 'Keringat di malam hari', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 2, 'kode' => 'D7', 'pertanyaan' => 'Nafsu makan berkurang', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 2, 'kode' => 'D8', 'pertanyaan' => 'Penurunan berat badan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 2, 'kode' => 'D9', 'pertanyaan' => 'Cepat lelah / letih / lesu', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 2, 'kode' => 'D10', 'pertanyaan' => 'Ada riwayat kontak (serumah ataupun tidak serumah) dengan penderita TBC / orang yang menjalani pengobatan selama 6 bulan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 2, 'kode' => 'D11', 'pertanyaan' => 'Menderita Diabetes Mellitus (DM)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 2, 'kode' => 'D12', 'pertanyaan' => 'Menderita Hipertensi', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 2, 'kode' => 'D13', 'pertanyaan' => 'Pernah pengobatan TBC sebelumnya / minum obat selama 6 bulan sebelumnya', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],

            // anak
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 1, 'kode' => 'A1', 'pertanyaan' => 'Apakah ada riwayat kontak (serumah ataupun tidak serumah) dengan orang dewasa yang menderita batuk lama / pengobatan TBC', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 1, 'kode' => 'A2', 'pertanyaan' => 'Batuk lama 2 minggu atau lebih', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 1, 'kode' => 'A3', 'pertanyaan' => 'Demam yang tidak diketahui penyebabnya', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 1, 'kode' => 'A4', 'pertanyaan' => 'Berat badan tidak naik atau turun dalam 2 bulan berturut-turut', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 1, 'kode' => 'A5', 'pertanyaan' => 'Nafsu makan turun', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 1, 'kode' => 'A6', 'pertanyaan' => 'Lemah / lesu / kurang aktif', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 1, 'kode' => 'A7', 'pertanyaan' => 'Keringat malam hari', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['uid_parameter' => Str::uuid(), 'kategori_id' => 1, 'kode' => 'A8', 'pertanyaan' => 'Benjolan di leher / ketiak / selangkangan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        foreach (array_chunk($data, 500) as $chunk) {
            DB::table('master_parameter_skrinings')->insert($chunk);
        }
    }
}
