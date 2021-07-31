<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Entry
 * @package App\Http\Resources
 * @mixin \App\Models\Entry
 */
class Entry extends JsonResource
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
            'show' => new Show($this->show),
            'membernumber' => $this->membernumber,
            'age' => $this->age,
            'can_retain_data' => $this->can_retain_data,
        ];
    }
}
