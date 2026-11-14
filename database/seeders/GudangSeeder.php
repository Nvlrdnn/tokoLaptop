<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GudangSeeder extends Seeder
{
    public function run()
    {
        $daftarLaptop = [
            [
                'nama_laptop' => 'ASUS ROG Strix G16 G614JU',
                'merek'       => 'ASUS',
                'spesifikasi' => 'Intel Core i7-13650HX • RAM 16GB DDR5 • SSD 512GB NVMe • RTX 4050 6GB • Layar 16" FHD+ 165Hz',
                'harga'       => 19499000,
                'stok'        => 5,
            ],
            [
                'nama_laptop' => 'Lenovo LOQ 15IRX9 Gaming',
                'merek'       => 'Lenovo',
                'spesifikasi' => 'Intel Core i5-13450HX • RAM 12GB DDR5 • SSD 512GB NVMe • RTX 3050 6GB • Layar 15.6" FHD 144Hz',
                'harga'       => 13299000,
                'stok'        => 7,
            ],
            [
                'nama_laptop' => 'Acer Swift Go 14 OLED',
                'merek'       => 'Acer',
                'spesifikasi' => 'Intel Core Ultra 7 155H • RAM 16GB LPDDR5X • SSD 1TB NVMe • Intel Arc Graphics • Layar 14" 2.8K OLED',
                'harga'       => 14999000,
                'stok'        => 4,
            ],
            [
                'nama_laptop' => 'HP Pavilion Aero 13-be2002AU',
                'merek'       => 'HP',
                'spesifikasi' => 'AMD Ryzen 7 7735U • RAM 16GB LPDDR5 • SSD 512GB NVMe • AMD Radeon Graphics • Bobot Ultra Ringan 990g',
                'harga'       => 12499000,
                'stok'        => 6,
            ],
            [
                'nama_laptop' => 'Apple MacBook Air M2 13-inch',
                'merek'       => 'Apple',
                'spesifikasi' => 'Apple M2 Chip (8-Core CPU, 8-Core GPU) • Unified Memory 8GB • SSD 256GB • Layar 13.6" Liquid Retina',
                'harga'       => 16499000,
                'stok'        => 3,
            ],
        ];

        foreach ($daftarLaptop as $item) {
            $data = [
                'nama_laptop' => $item['nama_laptop'],
                'stok'        => $item['stok'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ];

            // Menyesuaikan kolom merek & spesifikasi jika ada di tabel gudangs
            if (Schema::hasColumn('gudangs', 'merek')) {
                $data['merek'] = $item['merek'];
            }
            if (Schema::hasColumn('gudangs', 'spesifikasi')) {
                $data['spesifikasi'] = $item['spesifikasi'];
            }

            // Menyesuaikan nama kolom harga (harga_jual atau harga)
            if (Schema::hasColumn('gudangs', 'harga_jual')) {
                $data['harga_jual'] = $item['harga'];
            } elseif (Schema::hasColumn('gudangs', 'harga')) {
                $data['harga'] = $item['harga'];
            }

            // Menambahkan harga_beli jika tabel gudangs mewajibkannya
            if (Schema::hasColumn('gudangs', 'harga_beli')) {
                $data['harga_beli'] = $item['harga'] - 1500000;
            }

            DB::table('gudangs')->insert($data);
        }
    }
}