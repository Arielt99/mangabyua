<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //clean db
        DB::table('tags')->delete();

        //generate roles from json
        $json = File::get("database/data/tags.json");
        $data = json_decode($json);

        foreach($data as $obj){
            Tag::create([
                'name' => $obj->name,
                'slug' => Str::slug($obj->name),
                'isMature' => $obj->isMature,
            ]);
        }
    }
}
