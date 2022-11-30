<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use App\Http\Resources\ArticleResource;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserRole(Request $request)
    {
        $user = User::where("api_token", $request->api_token)->firstOrFail();

        return response()->json(["role" => $user->role->alias]);
    }

    public function getPublishedArticles()
    {
        return ArticleResource::collection(Article::where('published', true)
            ->where('user_id', '!=', null)
            ->orderByDesc('date_in')
            ->paginate(9));
    }
}
