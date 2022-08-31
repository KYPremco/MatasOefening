<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderAssemblyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'type' => 'assembly',
            'order_id' => $this->order_id,
            'name' => $this->assembly->name,
            'price' => $this->price,
            'components' => $this->assembly->components
        ];
    }
}
