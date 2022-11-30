<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Http\Requests\Admin\BlogCreateRequest;
use App\Http\Requests\Admin\BlogUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ImageService;
use Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $user = User::where('api_token', $request->api_token)->firstOrFail();
        if ($user->role->alias == "admin") {
            return ArticleResource::collection(Article::orderByDesc('created_at')->paginate(9));
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
    public function store(BlogCreateRequest $request)
    {
        //
        $data = $request->all();
        $data["image"] = ImageService::uploadImage($request);
        $data["published"] = $request->published == "true" ? 1 : 0;
        $data["paid_content"] = $request->paid_content == "true" ? 1 : 0;

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
    public function update(Request $request, $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Article::destroy($id);
    }

    public function postUpdate(BlogUpdateRequest $request, $id)
    {
        $article = Article::find($id);
        $data = $request->all();
        $image = ImageService::uploadImage($request);
        if ($image) {
            $data["image"] = $image;
        }
        unset($data["image"]);
        $data["published"] = $data["published"] == "true" || $data["published"] == 1 ? 1 : 0;
        $data["paid_content"] = $data["paid_content"] == "true" || $data["paid_content"] == 1 ? 1 : 0;

        return $article->update($data);
    }
}
