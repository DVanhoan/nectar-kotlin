<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('user','product')->paginate(20);
        return view('pages.favorites.index', compact('favorites'));
    }
}
