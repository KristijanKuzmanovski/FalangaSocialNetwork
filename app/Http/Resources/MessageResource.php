<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Message;
use App\User;
class MessageResource extends JsonResource
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
          'messageBody'=>$this->messageBody,
          'user_id'=>$this->user_id,
          'username'=>$this->user->name,
          'created_at'=>$this->created_at,
          'message_id'=>$this->id      
          ];
    }
}
