<?php

namespace App\Http\Controllers;

use App\Genre;
use Facades\App\Helpers\Json;
use App\Record;
use Illuminate\Http\Request;

class AltShopController extends Controller
{
    public function index()
    {
        $genres = Genre::orderBy('name')
            ->has('records')
            ->with('records')
            ->get();

        Json::dump($genres);
        return view('shop.alt_index', [
            'genres' => $genres
        ]);
    }
}
