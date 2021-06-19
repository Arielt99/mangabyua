<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TagFormRequest;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::query()
        ->orderBy('id', 'desc')
        ->get();

        return Inertia::render('Admin/Tag/Index', [
        'tags' => $tags
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Tag/Form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagFormRequest $request)
    {
        $validated = $request->validated();

        if(!$request->slug){
            $validated = array_merge($validated, ['slug'=>Str::slug($request->name)]);
        }

        Tag::create($validated);

        return redirect()->route('admin.tags.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        $tags = Tag::find($tag->id);
        if(!$tags){
            return back();
        }

        return Inertia::render('Admin/Tag/Show', [
            'tags' => $tags
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        $tags = Tag::find($tag->id);
        if(!$tags){
            return back();
        }
        return Inertia::render('Admin/Tag/Form', [
            'tags' => $tags
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagFormRequest $request, Tag $tag)
    {
        $validated = $request->validated();

        if(!$request->slug){
            $validated = array_merge($validated, ['slug'=>Str::slug($request->name)]);
        }

        $tags = Tag::findOrFail($tag->id);

        $tags->update($validated);

        $tags = Tag::findOrFail($tag->id);

        return $request->wantsJson()
        ? new JsonResponse('', 200)
        : back()->with('status', 'Tag updated')->with('tags', $tags);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        if(Auth::user()->hasRole('Super-Admin')){

            Tag::findOrFail($tag->id)->delete();

            return redirect()->route('admin.tags.index');
        }
    }
}
