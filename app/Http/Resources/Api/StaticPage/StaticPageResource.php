<?php

/**
 * Created by PhpStorm.
 * User: dimapopov
 * Skype: zambezi1991
 * Date: 06.04.2020
 * Time: 01:46
 */

namespace App\Http\Resources\Api\StaticPage;

use Illuminate\Http\Resources\Json\JsonResource;

class StaticPageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'content' => $this->content,
            'metaTitle' => $this->metaTitle,
            'metaDescription' => $this->meta_description,
            'slug' => $this->slug,
            'sortOrder' => $this->sort_order,
            'createdAt' => $this->created_at->timestamp,
            'updatedAt' => $this->updated_at->timestamp,
        ];
    }
}
