<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class EntrantResource
 * @package App\Http\Resources
 * @mixin \App\Models\Entrant
 */
class EntrantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        dump('entrant says');
//        dd($request->show);
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'family_name' => $this->family_name,
            'name' => $this->full_name,
            'membernumber' => $this->membernumber,
            'entries' => Entry::collection($this->whenLoaded('entries')),
            'age' => $this->age,
            'can_retain_data' => $this->can_retain_data,
            'team' => $this->when(
                $request->show instanceof Show,
                fn() => $this->teams()->wherePivot('show_id', $request->show->id)->first()
            ),
        ];
    }
}
