<?php

namespace Database\Seeders;

use App\Models\Faskes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FaskesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Karanganyar', 'alamat_faskes' => 'Jl. Lawu No. 2, Cangkan, Karanganyar', 'kec_id' => 331309, 'desakel_id' => 3313091006, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Tasikmadu', 'alamat_faskes' => 'Jl. Surakarta-Tawangmangu KM. 10, Ngijo', 'kec_id' => 331310, 'desakel_id' => 3313102003, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Jaten I', 'alamat_faskes' => 'Jl. Raya Solo-Tawangmangu KM. 9, Jaten', 'kec_id' => 331311, 'desakel_id' => 3313112003, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Jaten II', 'alamat_faskes' => 'Desa Ngringo, Jaten', 'kec_id' => 331311, 'desakel_id' => 3313112003, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Colomadu I', 'alamat_faskes' => 'Jl. Adi Sucipto No. 117, Paulan', 'kec_id' => 331312, 'desakel_id' => 3313122004, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Colomadu II', 'alamat_faskes' => 'Desa Bolon, Colomadu', 'kec_id' => 331312, 'desakel_id' => 3313122002, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Gondangrejo', 'alamat_faskes' => 'Jl. Solo-Purwodadi KM. 11, Tuban', 'kec_id' => 331313, 'desakel_id' => 3313132012, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Kebakkramat I', 'alamat_faskes' => 'Jl. Raya Solo-Sragen KM. 12, Pulosari', 'kec_id' => 331314, 'desakel_id' => 3313142008, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Kebakkramat II', 'alamat_faskes' => 'Desa Waru, Kebakkramat', 'kec_id' => 331314, 'desakel_id' => 3313142007, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Mojogedang I', 'alamat_faskes' => 'Jl. Raya Mojogedang, Mojogedang', 'kec_id' => 331315, 'desakel_id' => 3313152003, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Mojogedang II', 'alamat_faskes' => 'Desa Pojok, Mojogedang', 'kec_id' => 331315, 'desakel_id' => 3313152004, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Kerjo', 'alamat_faskes' => 'Jl. Jamus No. 1, Sumberejo', 'kec_id' => 331316, 'desakel_id' => 3313162009, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Jenawi', 'alamat_faskes' => 'Desa Jenawi, Kec. Jenawi', 'kec_id' => 331317, 'desakel_id' => 3313172003, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Karangpandan', 'alamat_faskes' => 'Jl. Lawu No. 45, Karangpandan', 'kec_id' => 331308, 'desakel_id' => 3313082007, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Ngargoyoso', 'alamat_faskes' => 'Jl. Karangpandan-Ngargoyoso, Kemuning', 'kec_id' => 331307, 'desakel_id' => 3313072005, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Tawangmangu', 'alamat_faskes' => 'Jl. Raya Tawangmangu-Matesih, Kalisoro', 'kec_id' => 331306, 'desakel_id' => 3313061003, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Matesih', 'alamat_faskes' => 'Jl. Raya Matesih-Tawangmangu, Matesih', 'kec_id' => 331305, 'desakel_id' => 3313052003, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Jumantono', 'alamat_faskes' => 'Jl. Raya Jumantono, Ngunut', 'kec_id' => 331304, 'desakel_id' => 3313042006, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Jumapolo', 'alamat_faskes' => 'Jl. Raya Jumapolo-Jatiyoso, Jumapolo', 'kec_id' => 331303, 'desakel_id' => 3313032011, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Jatiyoso', 'alamat_faskes' => 'Jl. Raya Jatiyoso, Desa Jatiyoso', 'kec_id' => 331302, 'desakel_id' => 3313022004, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'Puskesmas Jatipuro', 'alamat_faskes' => 'Jl. Raya Jatipuro-Wonogiri, Jatipuro', 'kec_id' => 331301, 'desakel_id' => 3313012003, 'created_at' => date('Y-m-d H:i:s')],

            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'RSUD Kartini', 'alamat_faskes' => 'Jalan Laksda Jl. Yos Sudarso, Jengglong', 'kec_id' => 331309, 'desakel_id' => 3313091008, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'RS PKU Muhammadiyah', 'alamat_faskes' => 'Jl. Jend. A. Yani, Gapura Papahan Indah, Papahan', 'kec_id' => 331310, 'desakel_id' => 3313102002, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => Str::uuid(), 'nama_faskes' => 'RS Jati Husada', 'alamat_faskes' => 'Jl. Raya Solo-Tawangmangu No.Km. 10, RW.3, Dusun VI, Jati', 'kec_id' => 331311, 'desakel_id' => 3313112002, 'created_at' => date('Y-m-d H:i:s')],
        ];

        foreach ($data as $key => $value) {
            Faskes::firstOrCreate($value);
        }
    }
}
