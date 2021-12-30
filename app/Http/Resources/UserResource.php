<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @package App\Http\Resources
 * @mixin \App\Models\User
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        dd($this->entrants);
//dump('user says');
//dd($request->show);

        $res = [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'family_name' => $this->last_name,
            'name' => $this->full_name,
            'membernumber' => $this->getMemberNumber(),
            'email' => $this->email,
            'address' => $this->address,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'address_town' => $this->address_town,
            'postcode' => $this->postcode,
            'can_email' => $this->can_email,
            'can_phone' => $this->can_phone,
            'can_sms' => $this->can_sms,
            'can_post' => $this->can_post,
            'can_retain_data' => $this->can_retain_data,
            'telephone' => $this->telephone,
            'status' => $this->status,
            'entrants' => EntrantResource::collection($this->entrants)->toArray($request),//->with($request),
            'membershipPurchases' => $this->membershipPurchases(),
        ];

//        dd($res);
        return $res;
    }
}
