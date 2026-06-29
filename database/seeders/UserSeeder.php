<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // superadmin
        // $data_super = [
        //     'uuid'      => Str::uuid(),
        //     'name'      => 'S. Admin',
        //     'username'  => 'superadmin',
        //     'password'  => '12345678',
        //     'email'     => 'admin@admin.com',
        //     'level'     => 'superadmin',
        // ];
        // $super = User::firstOrCreate($data_super);
        // $super->assignRole('superadmin');

        // admin
        $data_admin = [
            'uuid'      => Str::uuid(),
            'name'      => 'Admin Dinkes',
            'username'  => 'dinkes',
            'password'  => 'Dinkes@123',
            'email'     => 'dinkes@mail.com',
            'level'     => 'admin',
        ];

        $admin = User::firstOrCreate($data_admin);
        $admin->assignRole('admin');


        // // faskes
        // $data_faskes = [
        //     'uuid'      => Str::uuid(),
        //     'name'      => 'Karanganyar',
        //     'username'  => 'karanganyar',
        //     'password'  => '12345678',
        //     'email'     => 'karanganyar@mail.com',
        //     'level'     => 'faskes',
        //     'faskes_id' => '7b4c919d-102b-4b64-bebd-e59d6345a8ff',
        // ];

        // $data_faskes = [
        //     'uuid'      => Str::uuid(),
        //     'name'      => 'Pus. Jumantono',
        //     'username'  => 'jumantono',
        //     'password'  => '12345678',
        //     'email'     => 'jumantono@mail.com',
        //     'level'     => 'faskes',
        //     'faskes_id' => '7b4c919d-102b-4b64-bebd-e59d6345a8ff',
        // ];

        $data_faskes = [
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Karanganyar',
                'username'  => 'puskaranganyar',
                'password'  => 'Karanganyar@123',
                'email'     => 'fkaranganyar@mail.com',
                'level'     => 'faskes',
                'faskes_id' => '7b4c919d-102b-4b64-bebd-e59d6345a8ff',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Tasikmadu',
                'username'  => 'pustasikmadu',
                'password'  => 'Tasikmadu@123',
                'email'     => 'ftasikmadu@mail.com',
                'level'     => 'faskes',
                'faskes_id' => 'b12d2987-796f-4cfa-a177-a70f874ea681',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Jaten I',
                'username'  => 'pusjatensatu',
                'password'  => 'JatenI@123',
                'email'     => 'jaten1@mail.com',
                'level'     => 'faskes',
                'faskes_id' => 'b99d6846-f658-418e-9ca6-67dc5c15007f',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Jaten II',
                'username'  => 'pusjatendua',
                'password'  => 'JatenII@123',
                'email'     => 'jaten2@mail.com',
                'level'     => 'faskes',
                'faskes_id' => '053ab04b-3f2a-4ad5-876e-56cf1c5d337b',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Colomadu I',
                'username'  => 'puscolomadusatu',
                'password'  => 'ColomaduI@123',
                'email'     => 'colomadu1@mail.com',
                'level'     => 'faskes',
                'faskes_id' => '70a1b2d4-3465-4de5-aac8-e41956b47a8e',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Colomadu II',
                'username'  => 'puscolomadudua',
                'password'  => 'ColomaduII@123',
                'email'     => 'colomadu2@mail.com',
                'level'     => 'faskes',
                'faskes_id' => '599b00f5-42a9-410e-aa57-77d3686470c6',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Gondangrejo',
                'username'  => 'pusgondangrejo',
                'password'  => 'Gondangrejo@123',
                'email'     => 'gondangrejo@mail.com',
                'level'     => 'faskes',
                'faskes_id' => 'ed57a588-2da6-49e7-8d36-f86d573ab157',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Kebakkramat I',
                'username'  => 'puskebakkramatsatu',
                'password'  => 'KebakkramatI@123',
                'email'     => 'kebakkramat1@mail.com',
                'level'     => 'faskes',
                'faskes_id' => 'f28d6169-f8a5-410e-969b-71279e523505',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Kebakkramat II',
                'username'  => 'puskebakkramatdua',
                'password'  => 'KebakkramatII@123',
                'email'     => 'kebakkramat2@mail.com',
                'level'     => 'faskes',
                'faskes_id' => 'e1928929-5389-4bed-8f03-5bf33f3ba028',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Mojogedang I',
                'username'  => 'pusmojogedangsatu',
                'password'  => 'MojogedangI@123',
                'email'     => 'mojogedang1@mail.com',
                'level'     => 'faskes',
                'faskes_id' => '318f8682-e554-4076-9403-1f3c74835505',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Mojogedang II',
                'username'  => 'pusmojogedangdua',
                'password'  => 'MojogedangII@123',
                'email'     => '@mail.com',
                'level'     => 'faskes',
                'faskes_id' => 'b2e98324-645d-4a48-878f-585e92b77232',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Kerjo',
                'username'  => 'puskerjo',
                'password'  => 'Kerjo@123',
                'email'     => 'kerjo@mail.com',
                'level'     => 'faskes',
                'faskes_id' => '485688fe-46d0-4e2b-bc25-ac7dfbcf6c80',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Jenawi',
                'username'  => 'pusjenawi',
                'password'  => 'Jenawi@123',
                'email'     => 'jenawi@mail.com',
                'level'     => 'faskes',
                'faskes_id' => 'bbbc2b11-a842-4981-810c-2b42f4e15994',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Karangpandan',
                'username'  => 'puskarangpandan',
                'password'  => 'Karangpandan@123',
                'email'     => 'karangpandan@mail.com',
                'level'     => 'faskes',
                'faskes_id' => '7354e4bb-def8-4796-95f4-f36f01c48870',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Ngargoyoso',
                'username'  => 'pusngargoyoso',
                'password'  => 'Ngargoyoso@123',
                'email'     => 'ngargoyoso@mail.com',
                'level'     => 'faskes',
                'faskes_id' => '67228a42-eabc-435e-aabc-6000f5f14063',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Tawangmangu',
                'username'  => 'pustawangmangu',
                'password'  => 'Tawangmangu@123',
                'email'     => 'tawangmangu@mail.com',
                'level'     => 'faskes',
                'faskes_id' => 'e622c476-04d4-4f62-8941-9f5c1f91df70',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Matesih',
                'username'  => 'pusmatesih',
                'password'  => 'Matesih@123',
                'email'     => 'matesih@mail.com',
                'level'     => 'faskes',
                'faskes_id' => 'e415f1ff-e849-41c7-9263-c10ba6d315e7',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Jumantono',
                'username'  => 'pusjumantono',
                'password'  => 'Jumantono@123',
                'email'     => 'jumantono@mail.com',
                'level'     => 'faskes',
                'faskes_id' => '63404ebe-b556-43a3-9c7c-c993bca3eb8d',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Jumapolo',
                'username'  => 'pusjumapolo',
                'password'  => 'Jumapolo@123',
                'email'     => 'jumapolo@mail.com',
                'level'     => 'faskes',
                'faskes_id' => 'e12d286b-6d9e-4272-8cbf-29cd19c17cb7',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Jatiyoso',
                'username'  => 'pusjatiyoso',
                'password'  => 'Jatiyoso@123',
                'email'     => 'jatiyoso@mail.com',
                'level'     => 'faskes',
                'faskes_id' => 'd0ab686f-1221-4576-b0ed-1d164723680d',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'Puskesmas Jatipuro',
                'username'  => 'pusjatipuro',
                'password'  => 'Jatipuro@123',
                'email'     => 'jatipuro@mail.com',
                'level'     => 'faskes',
                'faskes_id' => '88f8c860-3cf1-47b6-b951-261874ce9028',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'RSUD Kartini',
                'username'  => 'kartini',
                'password'  => 'Kartini@123',
                'email'     => 'kartini@mail.com',
                'level'     => 'faskes',
                'faskes_id' => '8446c880-3611-488b-93e0-c234cd3f6831',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'RS PKU Muhammadiyah',
                'username'  => 'rspkukra',
                'password'  => 'Rspku@123',
                'email'     => 'pkumuhammadiyah@mail.com',
                'level'     => 'faskes',
                'faskes_id' => '39fbc42b-c439-4edc-bf83-6c1b38a9a0be',
            ],
            [
                'uuid'      => Str::uuid(),
                'name'      => 'RS Jati Husada',
                'username'  => 'jatihusada',
                'password'  => 'Jatihusada@123',
                'email'     => 'jatihusada@mail.com',
                'level'     => 'faskes',
                'faskes_id' => '6d65a985-2f99-49df-ba88-e5230b83bef9',
            ],
        ];

        foreach ($data_faskes as $key => $value) {
            $faskes = User::firstOrCreate($value);
            $faskes->assignRole('faskes');
        }
    }
}
