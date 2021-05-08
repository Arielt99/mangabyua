<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Container\Container;

class UserSeeder extends Seeder
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
        //clean db
        DB::table('users')->delete();

        //generate users from json
        $json = File::get("database/data/users.json");
        $data = json_decode($json);

        foreach($data as $obj){
            User::create(array(
                'first_name' => $obj->first_name,
                'last_name' => $obj->last_name,
                'username' => $obj->username,
                'email' => $obj->email,
                'password' => Hash::make($obj->password),
                'remember_token' => Str::random(10),
                'birthday' => Carbon::parse($this->faker->dateTimeBetween('1970-01-01', '2000-12-31')),
                'email_verified_at' => now(),
                'cgu_at' => now(),
                'cgv_at' => now(),
            ));
        }

        //add the role super-admin to the first user
        //clean db
        DB::table('model_has_roles')->delete();

        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' => "App\Models\User",
            'model_id' => 1,
        ]);
    }
}
