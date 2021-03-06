<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];


    /**
     * Get all of the manga that are assigned this media.
     */
    public function mangas()
    {
        return $this->morphedByMany(Manga::class, 'medias');
    }

    /**
     * Get all of the manga that are assigned this media.
     */
    public function chapters()
    {
        return $this->morphedByMany(Chapter::class, 'medias');
    }
}
