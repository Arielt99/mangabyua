<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'title',
        'manga_id',
    ];

    /**
     * Get all of the medias for the chapter.
     */
    public function medias()
    {
        return $this->morphToMany(Image::class, 'medias');
    }

    /**
     * Get the manga that owns the chapter.
     */
    public function mangas()
    {
        return $this->belongsTo(Manga::class);
    }
}
