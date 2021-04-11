<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Show
 * @package App\Http\Resources
 * @mixin \App\Models\Show
 */
class Show extends JsonResource
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
            'category' => $this->category_id,
            'paid' => $this->paid,
            'sections' => Section::collection($this->whenLoaded('sections')),
            'age' => $this->age,
            'can_retain_data' => $this->can_retain_data,
        ];
    }
}
