<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Post;
use App\User;

class PostResource extends JsonResource
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
          'postBody'=>$this->postBody,
          'likes'=>$this->likes,
          'dislikes'=>$this->dislikes,
          'comments'=>$this->comments,
          'user_id'=>$this->user_id,
          'post_id'=>$this->id,
          'created_at'=>$this->created_at->toDateTimeString(),
          'updated_at'=>$this->updated_at->toDateTimeString(),
          'username'=>$this->user->name,
          'profile_pic'=>asset('/images/profiles/'.$this->user->profile_pic)
        ];
    }

}
