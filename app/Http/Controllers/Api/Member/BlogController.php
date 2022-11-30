<?php

namespace App\Http\Controllers\Api\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Requests\Member\ArticleCreateRequest;
use App\Http\Requests\Member\ArticleUpdateRequest;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use App\Services\ImageService;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::where('api_token', $request->api_token)->firstOrFail();
        if ($user->role->alias == "member") {
            return ArticleResource::collection(Article::where("user_id", $user->id)
                ->orderByDesc('created_at')->paginate(9));
        } else {
            return abort(403, 'Ви не маєте прав на цей запит');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleCreateRequest $request)
    {
        //
        $user = User::where('api_token', $request->api_token)->firstOrFail();
        $data = $request->all();
        unset($data["api_token"]);
        $data["image"] = ImageService::uploadImage($request);
        $data["published"] = $request->published == "true" ? 1 : 0;
        $data["paid_content"] = $request->paid_content == "true" ? 1 : 0;
        $data["user_id"] = $user->id;

        return Article::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleUpdateRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $user = User::where('api_token', $request->api_token)->firstOrFail();
        $article = Article::find($id);
        if ($user->id != $article->user_id) {
            return abort(403, 'Ви не маєте прав на цей запит');
        }

        $article->delete();
    }

    public function postUpdate(ArticleUpdateRequest $request, $id)
    {
        $user = User::where('api_token', $request->api_token)->firstOrFail();
        $article = Article::find($id);
        if ($user->id != $article->user_id) {
            return abort(403, 'Ви не маєте прав на цей запит');
        }
        $data = $request->all();
        unset($data["api_token"]);
        $image = ImageService::uploadImage($request);
        if ($image) {
            $data["image"] = $image;
        }
        unset($data["image"]);
        $data["published"] = $data["published"] == "true" || $data["published"] == 1 ? 1 : 0;
        $data["paid_content"] = $data["paid_content"] == "true" || $data["paid_content"] == 1 ? 1 : 0;
        $data["user_id"] = $user->id;

        return $article->update($data);
    }
}
