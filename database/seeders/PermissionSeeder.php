<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menu Pengguna
        $pengguna = [
            'view pengguna',
            'update pengguna',
            'update username pengguna',
            'update password pengguna',
            'hapus pengguna',
            'view keluarga',
            'simpan keluarga',
            'update keluarga',
            'hapus keluarga'
        ];
        foreach ($pengguna as $key => $value) {
            Permission::firstOrCreate(['name' => $value]);
        }

        // Menu Cek Jantung dengan Hasil Lab.
        $lab = [
            'view cek jantung lab'
        ];
        foreach ($lab as $key => $value) {
            Permission::firstOrCreate(['name' => $value]);
        }

        // Menu Cek Jantung tanpa Hasil Lab.
        $nonlab = [
            'view cek jantung nonlab'
        ];
        foreach ($nonlab as $key => $value) {
            Permission::firstOrCreate(['name' => $value]);
        }

        // Menu Hasil Skrining
        $skrining = [
            'view hasil skrining',
            'download hasil skrining',
            'update hasil skrining',
            'hapus hasil skrining'
        ];
        foreach ($skrining as $key => $value) {
            Permission::firstOrCreate(['name' => $value]);
        }

        // Menu Cek Dahak
        $dahak = [
            'view cek dahak'
        ];
        foreach ($dahak as $key => $value) {
            Permission::firstOrCreate(['name' => $value]);
        }

        // Menu Pemantauan Obat
        $obat = [
            'view pemantauan obat'
        ];
        foreach ($obat as $key => $value) {
            Permission::firstOrCreate(['name' => $value]);
        }

        // Menu Admin & Faskes
        $admin = [
            'view admin dan faskes',
            'view admin',
            'simpan admin',
            'update admin',
            'username faskes',
            'password admin',
            'hapus admin',
            'view faskes',
            'simpan faskes',
            'update faskes',
            'username faskes',
            'password faskes',
            'hapus faskes',
            'view tempat faskes',
            'simpan tempat faskes',
            'update tempat faskes',
            'hapus tempat faskes'
        ];
        foreach ($admin as $key => $value) {
            Permission::firstOrCreate(['name' => $value]);
        }

        // Menu Profile
        $profile = [
            'view profile',
            'simpan profile',
            'ubah profile'
        ];
        foreach ($profile as $key => $value) {
            Permission::firstOrCreate(['name' => $value]);
        }

        // Menu Parameter Skrining
        $parameter = [
            'view parameter skrining'
        ];
        foreach ($parameter as $key => $value) {
            Permission::firstOrCreate(['name' => $value]);
        }

        // Menu Slider
        $slider = [
            'view slider',
            'simpan slider',
            'update slider',
            'hapus slider'
        ];
        foreach ($slider as $key => $value) {
            Permission::firstOrCreate(['name' => $value]);
        }

        // Menu Youtube
        $yt = [
            'view video',
            'simpan video',
            'update video',
            'hapus video'
        ];
        foreach ($yt as $key => $value) {
            Permission::firstOrCreate(['name' => $value]);
        }

        // Menu Youtube
        $yt = [
            'view role permission',
            'update role permission',
        ];
        foreach ($yt as $key => $value) {
            Permission::firstOrCreate(['name' => $value]);
        }

        // Menu Profile Saya
        $myprofile = [
            'view profile saya',
            'update profile saya',
            'ubah username saya',
            'ubah password saya'
        ];
        foreach ($myprofile as $key => $value) {
            Permission::firstOrCreate(['name' => $value]);
        }




        // sync the permission with role
        $rolePermissions = [
            'superadmin'=> Permission::all(),
            'admin'     => [
                'view pengguna', 'update pengguna', 'update password pengguna', 'hapus pengguna', 'view keluarga', 'simpan keluarga', 'update keluarga', 'hapus keluarga',
                'view cek jantung lab', 
                'view cek jantung nonlab', 
                'view hasil skrining', 
                'view cek dahak', 
                'view pemantauan obat', 
                'view profile', 'simpan profile', 'ubah profile',
                'view slider', 'simpan slider', 'update slider', 'hapus slider',
                'view video', 'simpan video', 'update video', 'hapus video',
                'view profile saya', 'update profile saya', 'ubah username saya', 'ubah password saya'
            ],
            'faskes'    => [
                'view pengguna', 'update pengguna', 'update password pengguna', 'hapus pengguna', 'view keluarga', 'simpan keluarga', 'update keluarga', 'hapus keluarga',
                'view hasil skrining', 
                'view cek dahak', 
                'view pemantauan obat',
                'view tempat faskes', 'simpan tempat faskes', 'update tempat faskes', 'hapus tempat faskes',
                'view profile saya', 'update profile saya', 'ubah username saya', 'ubah password saya'
            ],
            'user'      => [
                'view profile saya', 'update profile saya', 'ubah username saya', 'ubah password saya',
                'view hasil skrining'
            ]
        ];

        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::findByName($roleName);
            $role->syncPermissions($permissions);
        }
    }
}
