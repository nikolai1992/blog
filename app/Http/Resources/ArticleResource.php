<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "image" => $this->image,
            "slug" => $this->slug,
            "name" => $this->name,
            "title" => $this->title,
            "paid_content" => $this->paid_content,
            "short_description" => $this->short_description,
            "description" => $this->description,
            "date_in" => Carbon::parse($this->date_in)->format('Y-m-d'),
            "published" => $this->published,
            "views" => $this->views,
            "user_id" => $this->user_id,
            "author_name" => $this->author ? $this->author->name : null,
            "created_at" => Carbon::parse($this->created_at)->format('Y-m-d h:i:s'),
        ];
    }
}
