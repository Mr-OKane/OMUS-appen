<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'id' => $this->id,
            'line1' => $this->line1,
            'line2' => $this->line2,
            'postalCodes' => PostalCodeResource::collection($this->postalCodes),
            'create_at' => $this->created_at,
            'update_at' => $this->update_at,
        ];
    }
}
