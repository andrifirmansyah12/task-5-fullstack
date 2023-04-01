<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::join('users', 'articles.user_id', '=', 'users.id')
            ->join('categories', 'articles.category_id', '=', 'categories.id')
            ->get(['articles.*', 'users.name', 'categories.name_category']);
        return response()->json($articles);
    }
}
