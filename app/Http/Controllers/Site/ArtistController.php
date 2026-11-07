<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Artist;

class ArtistController extends Controller
{
    public function index() { return view('site.artists', ['artists' => Artist::orderBy('name')->get()]); }
}
