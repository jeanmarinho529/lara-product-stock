<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'category' => $this->category ? $this->category->name : null,
            'amount' => $this->amount,
            'current_quantity' => $this->current_quantity,
            'minimum_quantity' => $this->minimum_quantity
        ];
    }
}
