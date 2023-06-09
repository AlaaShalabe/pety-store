<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            // 'image',
            'price' => $this->price,
            'code'=> $this->code ,
            'category' => [
                'id'    => $this->category->id,
                'name' => $this->category->name
            ]
        ];
       // return parent::toArray($request);
    }
}
