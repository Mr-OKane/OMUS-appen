<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IdeaResource extends JsonResource
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
            'idea' => $this->idea,
            'create_at' => $this->created_at,
            'update_at' => $this->update_at,
        ];
    }
}
