<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //clean db
        DB::table('roles')->delete();

        //generate roles from json
        $json = File::get("database/data/roles.json");
        $data = json_decode($json);

        foreach($data as $obj){
            Role::create([
                'name' => $obj->name,
                'guard_name' => config('auth.defaults.guard')
            ]);
        }
    }
}
