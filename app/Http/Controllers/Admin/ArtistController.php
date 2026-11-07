<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArtistRequest;
use App\Models\Artist;

class ArtistController extends Controller
{
    public function index() { return view('admin.artists.index', ['artists' => Artist::withCount('quotes')->orderBy('name')->get()]); }

    public function store(ArtistRequest $request) { Artist::create($request->validated()); return back()->with('ok', 'Artist added.'); }

    public function edit(Artist $artist) { return view('admin.artists.edit', compact('artist')); }

    public function update(ArtistRequest $request, Artist $artist)
    {
        $artist->update($request->validated());
        return redirect()->route('admin.artists.index')->with('ok', 'Artist updated.');
    }

    public function destroy(Artist $artist) { $artist->delete(); return back()->with('ok', 'Artist removed.'); }
}
