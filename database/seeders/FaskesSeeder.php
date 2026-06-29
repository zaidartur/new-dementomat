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
            ['faskes_id' => '7b4c919d-102b-4b64-bebd-e59d6345a8ff', 'nama_faskes' => 'Puskesmas Karanganyar', 'alamat_faskes' => 'Jl. Lawu No. 2, Cangkan, Karanganyar', 'kec_id' => 331309, 'desakel_id' => 3313091006, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => 'b12d2987-796f-4cfa-a177-a70f874ea681', 'nama_faskes' => 'Puskesmas Tasikmadu', 'alamat_faskes' => 'Jl. Surakarta-Tawangmangu KM. 10, Ngijo', 'kec_id' => 331310, 'desakel_id' => 3313102003, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => 'b99d6846-f658-418e-9ca6-67dc5c15007f', 'nama_faskes' => 'Puskesmas Jaten I', 'alamat_faskes' => 'Jl. Raya Solo-Tawangmangu KM. 9, Jaten', 'kec_id' => 331311, 'desakel_id' => 3313112003, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => '053ab04b-3f2a-4ad5-876e-56cf1c5d337b', 'nama_faskes' => 'Puskesmas Jaten II', 'alamat_faskes' => 'Desa Ngringo, Jaten', 'kec_id' => 331311, 'desakel_id' => 3313112003, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => '70a1b2d4-3465-4de5-aac8-e41956b47a8e', 'nama_faskes' => 'Puskesmas Colomadu I', 'alamat_faskes' => 'Jl. Adi Sucipto No. 117, Paulan', 'kec_id' => 331312, 'desakel_id' => 3313122004, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => '599b00f5-42a9-410e-aa57-77d3686470c6', 'nama_faskes' => 'Puskesmas Colomadu II', 'alamat_faskes' => 'Desa Bolon, Colomadu', 'kec_id' => 331312, 'desakel_id' => 3313122002, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => 'ed57a588-2da6-49e7-8d36-f86d573ab157', 'nama_faskes' => 'Puskesmas Gondangrejo', 'alamat_faskes' => 'Jl. Solo-Purwodadi KM. 11, Tuban', 'kec_id' => 331313, 'desakel_id' => 3313132012, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => 'f28d6169-f8a5-410e-969b-71279e523505', 'nama_faskes' => 'Puskesmas Kebakkramat I', 'alamat_faskes' => 'Jl. Raya Solo-Sragen KM. 12, Pulosari', 'kec_id' => 331314, 'desakel_id' => 3313142008, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => 'e1928929-5389-4bed-8f03-5bf33f3ba028', 'nama_faskes' => 'Puskesmas Kebakkramat II', 'alamat_faskes' => 'Desa Waru, Kebakkramat', 'kec_id' => 331314, 'desakel_id' => 3313142007, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => '318f8682-e554-4076-9403-1f3c74835505', 'nama_faskes' => 'Puskesmas Mojogedang I', 'alamat_faskes' => 'Jl. Raya Mojogedang, Mojogedang', 'kec_id' => 331315, 'desakel_id' => 3313152003, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => 'b2e98324-645d-4a48-878f-585e92b77232', 'nama_faskes' => 'Puskesmas Mojogedang II', 'alamat_faskes' => 'Desa Pojok, Mojogedang', 'kec_id' => 331315, 'desakel_id' => 3313152004, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => '485688fe-46d0-4e2b-bc25-ac7dfbcf6c80', 'nama_faskes' => 'Puskesmas Kerjo', 'alamat_faskes' => 'Jl. Jamus No. 1, Sumberejo', 'kec_id' => 331316, 'desakel_id' => 3313162009, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => 'bbbc2b11-a842-4981-810c-2b42f4e15994', 'nama_faskes' => 'Puskesmas Jenawi', 'alamat_faskes' => 'Desa Jenawi, Kec. Jenawi', 'kec_id' => 331317, 'desakel_id' => 3313172003, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => '7354e4bb-def8-4796-95f4-f36f01c48870', 'nama_faskes' => 'Puskesmas Karangpandan', 'alamat_faskes' => 'Jl. Lawu No. 45, Karangpandan', 'kec_id' => 331308, 'desakel_id' => 3313082007, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => '67228a42-eabc-435e-aabc-6000f5f14063', 'nama_faskes' => 'Puskesmas Ngargoyoso', 'alamat_faskes' => 'Jl. Karangpandan-Ngargoyoso, Kemuning', 'kec_id' => 331307, 'desakel_id' => 3313072005, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => 'e622c476-04d4-4f62-8941-9f5c1f91df70', 'nama_faskes' => 'Puskesmas Tawangmangu', 'alamat_faskes' => 'Jl. Raya Tawangmangu-Matesih, Kalisoro', 'kec_id' => 331306, 'desakel_id' => 3313061003, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => 'e415f1ff-e849-41c7-9263-c10ba6d315e7', 'nama_faskes' => 'Puskesmas Matesih', 'alamat_faskes' => 'Jl. Raya Matesih-Tawangmangu, Matesih', 'kec_id' => 331305, 'desakel_id' => 3313052003, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => '63404ebe-b556-43a3-9c7c-c993bca3eb8d', 'nama_faskes' => 'Puskesmas Jumantono', 'alamat_faskes' => 'Jl. Raya Jumantono, Ngunut', 'kec_id' => 331304, 'desakel_id' => 3313042006, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => 'e12d286b-6d9e-4272-8cbf-29cd19c17cb7', 'nama_faskes' => 'Puskesmas Jumapolo', 'alamat_faskes' => 'Jl. Raya Jumapolo-Jatiyoso, Jumapolo', 'kec_id' => 331303, 'desakel_id' => 3313032011, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => 'd0ab686f-1221-4576-b0ed-1d164723680d', 'nama_faskes' => 'Puskesmas Jatiyoso', 'alamat_faskes' => 'Jl. Raya Jatiyoso, Desa Jatiyoso', 'kec_id' => 331302, 'desakel_id' => 3313022004, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => '88f8c860-3cf1-47b6-b951-261874ce9028', 'nama_faskes' => 'Puskesmas Jatipuro', 'alamat_faskes' => 'Jl. Raya Jatipuro-Wonogiri, Jatipuro', 'kec_id' => 331301, 'desakel_id' => 3313012003, 'created_at' => date('Y-m-d H:i:s')],

            ['faskes_id' => '8446c880-3611-488b-93e0-c234cd3f6831', 'nama_faskes' => 'RSUD Kartini', 'alamat_faskes' => 'Jalan Laksda Jl. Yos Sudarso, Jengglong', 'kec_id' => 331309, 'desakel_id' => 3313091008, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => '39fbc42b-c439-4edc-bf83-6c1b38a9a0be', 'nama_faskes' => 'RS PKU Muhammadiyah', 'alamat_faskes' => 'Jl. Jend. A. Yani, Gapura Papahan Indah, Papahan', 'kec_id' => 331310, 'desakel_id' => 3313102002, 'created_at' => date('Y-m-d H:i:s')],
            ['faskes_id' => '6d65a985-2f99-49df-ba88-e5230b83bef9', 'nama_faskes' => 'RS Jati Husada', 'alamat_faskes' => 'Jl. Raya Solo-Tawangmangu No.Km. 10, RW.3, Dusun VI, Jati', 'kec_id' => 331311, 'desakel_id' => 3313112002, 'created_at' => date('Y-m-d H:i:s')],
        ];

        foreach ($data as $key => $value) {
            Faskes::firstOrCreate($value);
        }
    }
}
