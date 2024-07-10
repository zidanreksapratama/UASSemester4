<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Criteria;
use App\Models\Kelas;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         // User::factory(10)->create();
         User::create([
            'name'     => 'Operator',
            'username' => 'adminer',
            'email'    => 'admin@spk.com',
            'password' => bcrypt('admin123'),
            'level'    => 'ADMIN'
        ]);

        Kelas::create([
            'kelas_name' => 'IX-A',
        ]);
        Kelas::create([
            'kelas_name' => 'IX-B',
        ]);
        Kelas::create([
            'kelas_name' => 'IX-C',
        ]);
        Kelas::create([
            'kelas_name' => 'IX-D',
        ]);

        Criteria::create([
            'name' => 'Nilai Rata-Rata Raport',
            'kategori' => 'BENEFIT',
            'Keterangan' => "Semakin tinggi nilai, semakin besar peluang"
        ]);
        Criteria::create([
            'name' => 'Absen Kehadiran',
            'kategori' => 'BENEFIT',
            'Keterangan' => "Semakin tinggi nilai, semakin besar peluang"
        ]);
        Criteria::create([
            'name' => 'Attitude',
            'kategori' => 'BENEFIT',
            'Keterangan' => "Semakin tinggi nilai, semakin besar peluang"
        ]);
        Criteria::create([
            'name' => 'Prestasi',
            'kategori' => 'BENEFIT',
            'Keterangan' => "Semakin tinggi nilai, semakin besar peluang"
        ]);
        Criteria::create([
            'name' => 'Aktif Dalam Ekstrakulikuler',
            'kategori' => 'BENEFIT',
            'Keterangan' => "Semakin tinggi nilai, semakin besar peluang"
        ]);
    }
}
