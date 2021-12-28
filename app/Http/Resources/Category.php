<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Category
 * @package App\Http\Resources
 * @mixin \App\Models\Category
 */
class Category extends JsonResource
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
            'name' => $this->name,
            'number' => $this->paid,
            'numbered_name' => $this->numbered_name,
            'membernumber' => $this->membernumber,
            'price' => $this->price,
            'late_price' => $this->late_price,
            'sortorder' => $this->sort_order,
            'first_prize' => $this->first_prize,
            'second_prize' => $this->second_prize,
            'third_prize' => $this->third_prize,
            'status' => $this->status,
        ];
    }
}
