<?php

namespace App\Http\Controllers\Mangaka;

use App\Http\Controllers\Controller;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MangaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mangas = Manga::query()
        ->with('mangakas')
        ->with('tags')
        ->whereHas('mangakas', function ($query) {
            return $query->where('mangaka_id', Auth::user()->id);
        })
        ->orderBy('id', 'desc')
        ->get();

        return Inertia::render('Mangaka/Manga/Index', [
        'mangas' => $mangas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->hasRole('Mangaka')){
            Manga::query()
            ->whereHas('mangakas', function ($query) {
                return $query->where('mangaka_id', Auth::user()->id);
            })
            ->findOrFail($id)
            ->delete();

            return redirect()->route('mangaka.mangas.index');
        }
    }
}
