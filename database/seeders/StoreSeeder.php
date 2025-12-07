<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\User;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil salah satu user dengan role member
        $member = User::where('role', 'member')->first();

        // Jika belum ada member, hentikan seeding
        if (!$member) {
            $this->command->warn("Tidak ada user dengan role member. Jalankan UserSeeder dulu.");
            return;
        }

        // Membuat satu toko milik member tersebut
        Store::create([
            'user_id'     => $member->id,
            'name'        => 'Toko Example',
            'logo'        => 'default-logo.png', // bisa disesuaikan
            'about'       => 'Ini adalah deskripsi singkat tentang toko.',
            'phone'       => '081234567890',
            'address_id'  => 1, // jika belum digunakan
            'city'        => 'Jakarta',
            'address'     => 'Jl. Contoh No. 123',
            'postal_code' => '12345',
            'is_verified' => false,
        ]);
    }
}
