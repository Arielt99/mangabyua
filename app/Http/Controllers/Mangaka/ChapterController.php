<?php

namespace App\Http\Controllers\Mangaka;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mangaka\ChapterFormRequest;
use App\Models\Chapter;
use App\Models\Image;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Manga  $manga
     * @return \Illuminate\Http\Response
     */
    public function create(Manga $manga)
    {
        $mangas = Manga::with('chapters')->findOrFail($manga->id);
        return Inertia::render('Mangaka/Manga/Chapter/Form', [
            'mangas' => $mangas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Manga  $manga
     * @return \Illuminate\Http\Response
     */
    public function store(ChapterFormRequest $request, Manga $manga)
    {
        $validated = $request->validated();

        $validated = array_merge($validated, ['manga_id'=> $manga->id]);
        unset($validated['medias']);

        //chapter creation
        $chapter = Chapter::create($validated);

        foreach ($request->medias as $media) {
            //media creation
            $uploadedFileUrl = cloudinary()->upload($media->getRealPath())->getSecurePath();

            $page = new Image();
            $page->url = $uploadedFileUrl;
            $page->save();

            $chapter->medias()->save($page);
        }

        return redirect()->route('mangaka.mangas.show',  ['manga' => $manga->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Manga  $manga
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function show(Manga $manga, Chapter $chapter)
    {
        $mangas = Manga::findOrFail($manga->id);
        $chapters = Chapter::query()
        ->with('medias')
        ->find($chapter->id);

        if(!$chapters){
            return back();
        }

        return Inertia::render('Mangaka/Manga/Chapter/Show', [
            'mangas' => $mangas,
            'chapters' => $chapters
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function edit(Chapter $chapter)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chapter $chapter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Manga  $manga
     * @param  \App\Models\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manga $manga, Chapter $chapter)
    {
        if(Auth::user()->hasRole('Mangaka')){
            Chapter::query()
            ->findOrFail($chapter->id)
            ->delete();

            return redirect()->route('mangaka.mangas.show', ['manga' => $manga->id]);
        }
    }
}
