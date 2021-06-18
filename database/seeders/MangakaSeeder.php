<?php

namespace Database\Seeders;


use App\Models\User;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Container\Container;
use Spatie\Permission\Models\Role;

class MangakaSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //generate mangakas from json
        $json = File::get("database/data/mangakas.json");
        $data = json_decode($json);

        foreach($data as $obj){
            User::create(array(
                'first_name' => $obj->first_name,
                'last_name' => $obj->last_name,
                'username' => $obj->username,
                'email' => $obj->email,
                'password' => isset($obj->password) ? Hash::make($obj->password) : Hash::make("Password-1234"),
                'remember_token' => Str::random(10),
                'birthday' => isset($obj->birthday) ? Carbon::parse($obj->birthday): Carbon::parse($this->faker->dateTimeBetween('1970-01-01', '2000-12-31')),
                'email_verified_at' => now(),
                'cgu_at' => now(),
                'cgv_at' => now(),
            ))->assignRole(Role::findOrCreate('Mangaka'));
        }
    }
}
