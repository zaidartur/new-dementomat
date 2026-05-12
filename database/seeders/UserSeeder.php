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
        // $data = [
        //     'uuid'      => Str::uuid(),
        //     'name'      => 'S. Admin',
        //     'username'  => 'superadmin',
        //     'password'  => '12345678',
        //     'email'     => 'admin@admin.com',
        //     'level'     => 'superadmin',
        // ];

        $data = [
            'uuid'      => Str::uuid(),
            'name'      => 'Admin',
            'username'  => 'admin',
            'password'  => '12345678',
            'email'     => 'mail@admin.com',
            'level'     => 'admin',
        ];

        // foreach (array_chunk($data, 500) as $chunk) {
        //     DB::table('users')->insert($chunk);
        // }

        $user = User::create($data);
        $user->assignRole('admin');
    }
}
