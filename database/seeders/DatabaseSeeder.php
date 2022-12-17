<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
         \App\Models\User::factory(10)->create();

        DB::table('users')->insert([
            'name' => 'netbina',
            'email' => 'netbina@m.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
        ]);

        DB::table('users')->insert([
            'name' => 'milad',
            'email' => 'milad@m.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
        ]);

        $this->call([
            TaskSeeder::class,
        ]);

    }
}
