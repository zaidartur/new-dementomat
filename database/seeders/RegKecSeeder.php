<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegKecSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kec_id' => '331301', 'kotakab_id' => '3313', 'kec_name' => 'Jatipuro'],
            ['kec_id' => '331302', 'kotakab_id' => '3313', 'kec_name' => 'Jatiyoso'],
            ['kec_id' => '331303', 'kotakab_id' => '3313', 'kec_name' => 'Jumapolo'],
            ['kec_id' => '331304', 'kotakab_id' => '3313', 'kec_name' => 'Jumantono'],
            ['kec_id' => '331305', 'kotakab_id' => '3313', 'kec_name' => 'Matesih'],
            ['kec_id' => '331306', 'kotakab_id' => '3313', 'kec_name' => 'Tawangmangu'],
            ['kec_id' => '331307', 'kotakab_id' => '3313', 'kec_name' => 'Ngargoyoso'],
            ['kec_id' => '331308', 'kotakab_id' => '3313', 'kec_name' => 'Karangpandan'],
            ['kec_id' => '331309', 'kotakab_id' => '3313', 'kec_name' => 'Karanganyar'],
            ['kec_id' => '331310', 'kotakab_id' => '3313', 'kec_name' => 'Tasikmadu'],
            ['kec_id' => '331311', 'kotakab_id' => '3313', 'kec_name' => 'Jaten'],
            ['kec_id' => '331312', 'kotakab_id' => '3313', 'kec_name' => 'Colomadu'],
            ['kec_id' => '331313', 'kotakab_id' => '3313', 'kec_name' => 'Gondangrejo'],
            ['kec_id' => '331314', 'kotakab_id' => '3313', 'kec_name' => 'Kebakkramat'],
            ['kec_id' => '331315', 'kotakab_id' => '3313', 'kec_name' => 'Mojogedang'],
            ['kec_id' => '331316', 'kotakab_id' => '3313', 'kec_name' => 'Kerjo'],
            ['kec_id' => '331317', 'kotakab_id' => '3313', 'kec_name' => 'Jenawi'],
        ];

        foreach (array_chunk($data, 500) as $chunk) {
            DB::table('kecamatans')->insert($chunk);
        }
    }
}
