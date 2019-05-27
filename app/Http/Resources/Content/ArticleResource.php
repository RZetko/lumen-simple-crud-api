<?php

namespace App\Http\Resources\Content;

use Illuminate\Http\Resources\Json\Resource;

class ArticleResource extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'thumbnail' => $this->thumbnail->content,
            'title' => $this->title,
            'subtitle' => $this->subtitle,    
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
