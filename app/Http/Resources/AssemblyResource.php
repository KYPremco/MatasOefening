<?php

namespace App\Http\Resources;

use App\Models\Assembly;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Assembly
 * */
class AssemblyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @this Ass
     * @param  Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "price" => $this->price,
            "image" => asset('storage/' . $this->image),
            "manufacturer" => $this->whenLoaded('manufacturer'),
            "components" => $this->whenLoaded('components'),
        ];
    }
}
