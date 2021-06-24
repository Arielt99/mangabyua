<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Image;
use App\Models\Manga;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //generate users from json
        $json = File::get("database/data/chapters.json");
        $data = json_decode($json);

        foreach($data as $obj){
            $chapter = Chapter::create(array(
                'title' => $obj->title,
                'number' => $obj->number,
                'manga_id' => Manga::where('title', $obj->manga)->first()->id
            ));

            $chapterPagesFolder = File::files('database/data/chapters/'.$obj->pagesFolder);
            foreach ($chapterPagesFolder as $page) {
                //media creation
                $uploadedFileUrl = cloudinary()->upload($page->getRealPath())->getSecurePath();

                $page = new Image();
                $page->url = $uploadedFileUrl;
                $page->save();

                $chapter->medias()->save($page);
            }
        }
    }
}


