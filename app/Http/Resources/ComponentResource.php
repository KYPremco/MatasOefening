<?php

namespace App\Http\Resources;

use App\Models\Assembly;
use App\Models\Component;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Component
 * */
class ComponentResource extends JsonResource
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
            "type" => $this->type,
            "price" => $this->price,
            "image" => asset('storage/' . $this->image),
            "assemblies" => AssemblyResource::collection($this->whenLoaded('assemblies')),
        ];
    }
}
