<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manga extends Model
{
    use HasFactory, SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'isMature',
        'cover'
    ];

    /**
     *
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_manga');
    }

    /**
     *
     */
    public function mangakas()
    {
        return $this->belongsToMany(User::class, 'mangaka_manga', 'manga_id', 'mangaka_id');
    }

    /**
     * Get all of the medias for the manga.
     */
    public function medias()
    {
        return $this->morphToMany(Image::class, 'medias');
    }

    /**
     * Get the comments for the blog post.
     */
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}
