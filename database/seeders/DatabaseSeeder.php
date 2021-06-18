<?php

namespace Database\Seeders;

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
        $this->call([
            RoleSeeder::class,
            TagSeeder::class,
            AdminSeeder::class,
            MangakaSeeder::class,
            UserSeeder::class,
            MangaSeeder::class,
        ]);
    }
}
