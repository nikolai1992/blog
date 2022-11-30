<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class BlogController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('blog');
    }

    public function read_article($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        $other_articles = Article::where('id', '!=', $article->id)->orderByDesc('views')->limit(3)->get();

        if (auth()->user()->role->alias == "free" && $article->paid_content) {
            return abort(403, 'Ви не маєте прав на читання цієї світлини. Оформіть підписку.');
        }

        $article->views = $article->views + 1;
        $article->save();

        return view('one_article', compact('article', 'other_articles'));
    }
}
