<?php

namespace App\Http\Resources\Article;

use App\Enums\DateFormat;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'thumbnail' => photo_url($this->thumbnail, $this->title),
            'is_published' => $this->is_published,
            'created_at' => $this->created_at->format(DateFormat::WITH_TIME),
            'updated_at' => $this->updated_at->format(DateFormat::WITH_TIME),
            'last_update' => $this->updated_at->format(DateFormat::DAY_DATE_TIME),
            'deleted_at' => $this->deleted_at ? $this->deleted_at->format(DateFormat::WITH_TIME) : null,
        ];
    }
}
