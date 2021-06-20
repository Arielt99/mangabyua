<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Manga;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MangaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //generate users from json
        $json = File::get("database/data/mangas.json");
        $data = json_decode($json);

        foreach($data as $obj){
            $manga = Manga::create(array(
                'title' => $obj->title,
                'slug' => Str::slug($obj->title),
                'description' => $obj->description,
            ));

            //add the mangakas
            foreach($obj->authors as $author){
                $manga->mangakas()->attach(User::whereRoleIsMangaka()->whereFullNameIs($author)->get()->pluck('id'));
            }

            //add the tags
            foreach($obj->tags as $tag){
                $manga->tags()->attach(Tag::where("name", $tag)->get()->pluck('id'));
            }

            $uploadedFileUrl = cloudinary()->upload('database/data/covers/'.$obj->cover)->getSecurePath();

            $cover = new Image();
            $cover->url = $uploadedFileUrl;
            $cover->save();

            $manga->medias()->delete();

            $manga->medias()->sync($cover);

            if($manga->tags()->where('isMature', true)->exists()){
                $manga->isMature = true;
                $manga->save();
            }

        }
    }
}


