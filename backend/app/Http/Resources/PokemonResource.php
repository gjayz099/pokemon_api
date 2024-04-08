<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PokemonResource extends JsonResource
{
   /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "Name" => $this->Name,
            'Picture' => $this->Picture,
            "types" => TypeResource::collection($this->whenLoaded('types')),
            "abilities" => AbilityResource::collection($this->whenLoaded('abilities')),
            "experiences" => ExperienceResource::make($this->whenLoaded('experiences')),
        ];
    }
}
