<?php

namespace App\Http\Resources\Message;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class FeedbackResource extends JsonResource
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
            'message'      => $this->message,
            'is_feedback'   => $this->is_feedback,
            'user_id'  => Auth::user()->id,
        ];
    }
}
