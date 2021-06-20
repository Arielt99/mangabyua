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
     * Get all of the posts that are assigned this tag.
     */
    public function mangas()
    {
        return $this->morphedByMany(Manga::class, 'medias');
    }
}
