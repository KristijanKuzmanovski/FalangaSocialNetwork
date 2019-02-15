<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Comment;

class CommentResource extends JsonResource
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
          'username'=>$this->user->name,
          'created_at'=>$this->created_at->toDateTimeString(),
          'updated_at'=>$this->created_at->toDateTimeString(),
          'commentBody'=>$this->commentBody,
          'user_id'=>$this->user_id,
          'post_id'=>$this->post_id,
          'comment_id'=>$this->id,
          'profile_pic'=>asset('/images/profiles/'.$this->user->profile_pic)
        ];
    }
}
