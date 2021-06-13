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
            'firstname' => $this->firstname,
            'familyname' => $this->familyname,
            'name' => $this->getName(),
            'membernumber' => $this->membernumber,
            'entries' => Entry::collection($this->whenLoaded('entries')),
            'age' => $this->age,
            'can_retain_data' => $this->can_retain_data,
            'team' => $this->when(
                $request->show instanceof Show,
                function () use ($request){
                    return $this->teams()->wherePivot('show_id', $request->show->id)->first();}),
        ];
    }
}
