<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //generate admins from json
        $json = File::get("database/data/admins.json");
        $data = json_decode($json);

        foreach($data as $obj){
            User::create(array(
                'first_name' => $obj->first_name,
                'last_name' => $obj->last_name,
                'username' => $obj->username,
                'email' => $obj->email,
                'password' => isset($obj->password) ? Hash::make($obj->password) : Hash::make("Password-1234"),
                'remember_token' => Str::random(10),
                'birthday' => isset($obj->birthday) ? Carbon::parse($obj->birthday): null,
                'email_verified_at' => now(),
                'cgu_at' => now(),
                'cgv_at' => now(),
            ))->assignRole(Role::findOrCreate('Super-Admin'));
        }
    }
}
