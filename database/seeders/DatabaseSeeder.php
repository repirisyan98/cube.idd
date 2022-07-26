<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'telefon' => '082736377363',
            'foto' => 'default.png',
            'rajaongkir_citie_id' => 104,
            'role' => "1",
            'email_verified_at' => now(),
            'alamat' => 'Cianjur'
        ]);
    }
}