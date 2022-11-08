<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Toko;
use App\Models\User;
use App\Models\Driver;
use App\Models\Role;
use App\Models\Pengiriman;
use App\Models\RiwayatPerubahanStok;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $today = date('Y-m-d');

        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('admindc'),
            'role_id' => '1'
        ])->roles()->attach(1);

        User::create([
            'name' => 'Rizki Dwi Kurnia',
            'username' => 'rizki',
            'password' => bcrypt('admindc'),
            'role_id' => '1'
        ])->roles()->attach(1);

        Toko::create([
            'kode_toko' => '6A01',
            'nama_toko' => 'Tangerang',
            'alamat' => 'Tangerang',
            'operasional' => '1',
            'status' => '1',
        ]);

        Toko::create([
            'kode_toko' => '6A02',
            'nama_toko' => 'Raharja',
            'alamat' => 'Jl. Jendral Sudirman no.40',
            'operasional' => '1',
            'status' => '1',
        ]);

        Driver::create([
            'nik' => '1234567890',
            'nama' => 'Rizki Dwi',
            'slug' => 'rizki-dwi',
            'email' => 'rizki@gmail.com',
            'no_telepon' => '08123123123'
        ]);

        Barang::insert([
            [
                'kode' => 'B0001',
                'kategori' => 'reguler',
                'nama' => 'Air Mineral',
                'stok' => '10000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'B0002',
                'kategori' => 'reguler',
                'nama' => 'Cola',
                'stok' => '1000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'B0003',
                'kategori' => 'reguler',
                'nama' => 'Indomie',
                'stok' => '2000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'B0004',
                'kategori' => 'reguler',
                'nama' => 'Kopi',
                'stok' => '300',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'B0005',
                'kategori' => 'reguler',
                'nama' => 'Susu',
                'stok' => '300',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'F0001',
                'kategori' => 'fresh food',
                'nama' => 'Onigiri',
                'stok' => '20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'F0002',
                'kategori' => 'fresh food',
                'nama' => 'Bento',
                'stok' => '20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'F0003',
                'kategori' => 'fresh food',
                'nama' => 'Gohan',
                'stok' => '20',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);

        RiwayatPerubahanStok::create([
            'kode_barang' => 'F0001',
            'nama_barang' => 'Air Mineral',
            'stok_sistem' => '100',
            'stok_fisik' => '150',
            'selisih' => '50',
            'keterangan' => 'positif'
        ]);

        Pengiriman::create([
            'no_stpb' => '123123',
            'driver_id' => '1',
            'toko_id' => '1',
            'tanggal' => $today,
            'no_polisi' => 'B 123 ASDf',
            'kategori' => 'reguler',
            'kotak_peluru' => '0',
            'status' => '1',
            'waktu_kirim' => '12:00:00'
        ]);

        Pengiriman::create([
            'no_stpb' => '2233',
            'driver_id' => '1',
            'toko_id' => '1',
            'tanggal' => $today,
            'no_polisi' => 'B 123 QWE',
            'kategori' => 'reguler',
            'kotak_peluru' => '0',
            'status' => '1',
            'waktu_kirim' => '12:00:00'
        ]);

        Pengiriman::create([
            'no_stpb' => '1234',
            'driver_id' => '1',
            'toko_id' => '1',
            'tanggal' => '2022-04-25',
            'no_polisi' => 'B 123 QWE',
            'kategori' => 'reguler',
            'kotak_peluru' => '0',
            'status' => '1',
            'waktu_kirim' => '13:00:00'
        ]);

        User::create([
            'name' => '6A01',
            'username' => '6A01',
            'password' => bcrypt('toko123'),
            'role_id' => '2'
        ])->roles()->attach(2);

        User::create([
            'name' => '6A02',
            'username' => '6A02',
            'password' => bcrypt('toko123'),
            'role_id' => '2'
        ])->roles()->attach(2);

        User::create([
            'name' => 'Rizki Dwi Kurnia',
            'username' => 'rizki@gmail.com',
            'password' => bcrypt('driver'),
            'role_id' => '3'
        ])->roles()->attach(3);

        User::create([
            'name' => 'Manajer',
            'username' => 'manajer',
            'password' => bcrypt('manajerdc'),
            'role_id' => '4'
        ])->roles()->attach(4);

        Toko::factory(15)->create();

        Driver::factory(5)->create();

        Pengiriman::factory(100)->create();

        Role::create([
            'nama_role' => 'admin'
        ]);
        Role::create([
            'nama_role' => 'toko'
        ]);
        Role::create([
            'nama_role' => 'driver'
        ]);
        Role::create([
            'nama_role' => 'manajer'
        ]);
    }
}
