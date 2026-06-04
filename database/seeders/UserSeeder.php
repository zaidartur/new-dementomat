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
        $data_super = [
            'uuid'      => Str::uuid(),
            'name'      => 'S. Admin',
            'username'  => 'superadmin',
            'password'  => '12345678',
            'email'     => 'admin@admin.com',
            'level'     => 'superadmin',
        ];
        $super = User::firstOrCreate($data_super);
        $super->assignRole('superadmin');

        // admin
        $data_admin = [
            'uuid'      => Str::uuid(),
            'name'      => 'Admin',
            'username'  => 'admin',
            'password'  => '12345678',
            'email'     => 'mail@admin.com',
            'level'     => 'admin',
        ];

        $admin = User::firstOrCreate($data_admin);
        $admin->assignRole('admin');


        // faskes
        $data_faskes = [
            'uuid'      => Str::uuid(),
            'name'      => 'Karanganyar',
            'username'  => 'karanganyar',
            'password'  => '12345678',
            'email'     => 'karanganyar@faskes.com',
            'level'     => 'faskes',
            'faskes_id' => '7b4c919d-102b-4b64-bebd-e59d6345a8ff',
        ];

        $faskes = User::firstOrCreate($data_faskes);
        $faskes->assignRole('faskes');
    }
}
