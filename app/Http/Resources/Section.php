<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Section
 * @package App\Http\Resources
 * @mixin \App\Models\Section
 */
class Section extends JsonResource
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
            'name' => $this->category_id,
            'number' => $this->number,
            'membernumber' => $this->membernumber,
            'categories' => Category::collection($this->categories()),//TODO make this use a pivot
            'notes' => $this->notes,
            'judges' => $this->judges,
            'image' => $this->image,
        ];
    }
}
