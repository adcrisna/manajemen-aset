<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name'	=> 'Admin',
            'email'	=> 'admin@app.com',
            'password'	=> bcrypt('password'),
            'username' => 'admin',
            'telepon' => '08312312322',
            'foto' => null,
            'level' => 'Admin',
        ]);
        DB::table('users')->insert([
            'name'	=> 'Pimpinan',
            'email'	=> 'pimpinan@app.com',
            'password'	=> bcrypt('password'),
            'username' => 'pimpinan',
            'telepon' => '08312312322',
            'foto' => null,
            'level' => 'Pimpinan',
        ]);
    }
}
