<?php

namespace App\Http\Controllers\Mangaka;

use App\Http\Controllers\Controller;
use App\Models\Manga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MangakaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mangas =  Manga::query()
        ->whereHas('mangakas', function ($query) {
            return $query->where('mangaka_id', Auth::user()->id);
        })
        ->orderBy('id', 'desc')
        ->get();

        return Inertia::render('Mangaka/Dashboard', [
            'mangas' => $mangas
        ]);
    }
}
