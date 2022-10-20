<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => $this->password,
            'instruments' => InstrumentResource::collection($this->instruments),
            'roles' => RoleResource::collection($this->roles),
            'orders' => OrderResource::collection($this->orders),
            'create_at' => $this->created_at,
            'update_at' => $this->update_at,
        ];
    }
}
