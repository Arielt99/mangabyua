<?php

namespace App\Http\Controllers\Mangaka;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mangaka\MangaFormRequest;
use App\Models\Image;
use App\Models\Manga;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use CloudinaryLabs\CloudinaryLaravel\Model\Media;

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
        ->with('medias')
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
        $mangakas = User::query()
                    ->whereRoleIsMangaka()
                    ->get();

        $tags = Tag::query()
                    ->get();

        return Inertia::render('Mangaka/Manga/Form', [
            'mangakas' => $mangakas,
            'tags' => $tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MangaFormRequest $request)
    {
        $validated = $request->validated();

        $validated = array_merge($validated, ['slug'=>Str::slug($request->title)]);
        unset($validated['cover']);


        //media creation
        $uploadedFileUrl = cloudinary()->upload($request->file('cover')->getRealPath())->getSecurePath();

        $cover = new Image;
        $cover->url = $uploadedFileUrl;
        $cover->save();

        //manga creation
        $mangas = Manga::create($validated);

        $mangas->medias()->save($cover);

        $mangas->tags()->sync($request->tags);

        $mangas->mangakas()->sync($request->mangakas);

        return redirect()->route('mangaka.mangas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mangas = Manga::query()
        ->with('mangakas')
        ->with('tags')
        ->with('medias')
        ->with(['chapters' => function ($query) {
            $query->orderBy('id', 'DESC');
        }])
        ->whereHas('mangakas', function ($query) {
            return $query->where('mangaka_id', Auth::user()->id);
        })
        ->find($id);

        if(!$mangas){
            return back();
        }

        return Inertia::render('Mangaka/Manga/Show', [
            'mangas' => $mangas
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mangas = collect(Manga::query()
        ->with('medias')
        ->whereHas('mangakas', function ($query) {
            return $query->where('mangaka_id', Auth::user()->id);
        })
        ->find($id));

        if(!$mangas){
            return back();
        }

        $mangas->put('tags', array_values(Manga::query()->findOrFail($id)->tags->pluck('id')->toArray()));
        $mangas->put('mangakas', array_values(Manga::query()->findOrFail($id)->mangakas->pluck('id')->toArray()));

        $mangakas = User::query()
        ->whereRoleIsMangaka()
        ->get();

        $tags = Tag::query()
                ->get();

        return Inertia::render('Mangaka/Manga/Form', [
        'mangakas' => $mangakas,
        'tags' => $tags,
        'mangas' => $mangas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MangaFormRequest $request, $id)
    {
        $validated = $request->validated();

        $validated = array_merge($validated, ['slug'=>Str::slug($request->title)]);
        unset($validated['cover']);


        //media creation
        $uploadedFileUrl = cloudinary()->upload($request->file('cover')->getRealPath())->getSecurePath();

        $cover = new Image;
        $cover->url = $uploadedFileUrl;
        $cover->save();

        //manga update
        $mangas = Manga::query()
        ->whereHas('mangakas', function ($query) {
            return $query->where('mangaka_id', Auth::user()->id);
        })
        ->findOrFail($id);

        $mangas->update($validated);

        $mangas->medias()->delete();

        $mangas->medias()->sync($cover);

        $mangas->tags()->sync($request->tags);

        $mangas->mangakas()->sync($request->mangakas);

        return $request->wantsJson()
        ? new JsonResponse('', 200)
        : back()->with('status', 'Manga updated');
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
