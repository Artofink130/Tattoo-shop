<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Artist;

class HomeController extends Controller
{
    public function __invoke()
    {
        // Any photos dropped into public/gallery appear in the home page gallery.
        $gallery = collect(glob(public_path('gallery/*.{jpg,jpeg,png,webp}'), GLOB_BRACE) ?: [])->map(fn ($p) => '/gallery/'.basename($p));
        return view('site.home', ['artists' => Artist::take(4)->get(), 'gallery' => $gallery]);
    }
}
