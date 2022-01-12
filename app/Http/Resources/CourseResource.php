<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'rating' => $this->rating,
            'view' => $this->view,
            'level' => $this->level,
            'hours' => $this->hours,
            'created_at' => $this->created_at ? $this->created_at->diffForHumans() : NULL,
            'categories' => CategoryResource::make( $this->category ),
        ];
    }

}
