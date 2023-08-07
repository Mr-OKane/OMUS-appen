<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PracticeDateResource extends JsonResource
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
            'practice' => $this->practice,
            'teams' => TeamResource::collection($this->teams),
            'create_at' => $this->created_at,
            'update_at' => $this->update_at,
        ];
    }
}
