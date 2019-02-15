<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vote;
use App\Post;
use App\User;
use App\Events\NewVote;
use App\Notifications\VotedOnPostNotification;
use App\NotificationModels\VotedOnPostModel;

class VotesController extends Controller
{
  //TODO: Delete all votes form a user function
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request,[
        'type'=>'required',
        'post_id'=>'required'
      ]);
      $type=$request->input('type');
      $id=$request->input('post_id');
      $posts=Post::where('id',$id)->get();
      $post=$posts[0];
      if(empty($post)){
        return 'No post with that id';
      }

      $user=auth()->user()->id;
      $votes=Vote::where([['user_id',$user],['post_id',$id]])->get();
      $user_like=0;
      $user_dislike=0;


      if(count($votes)>0){
        $vote=$votes[0];
        $user_like=$vote->like;
        $user_dislike=$vote->dislike;
        if($type === 'like'){
          if($user_dislike === 1){
            $post->dislikes=$post->dislikes-1;
          }
          $user_dislike=0;
          if($user_like === 1){
            $user_like=0;
            $post->likes=$post->likes-1;
          }
          else{
            $user_like=1;
            $post->likes=$post->likes+1;
          }
        }
        else if ($type === 'dislike'){
          if($user_like === 1){
            $post->likes=$post->likes-1;
          }
                $user_like=0;
                if($user_dislike === 1){
                  $user_dislike=0;
                  $post->dislikes=$post->dislikes-1;
                }
                else{
                  $user_dislike=1;
                  $post->dislikes=$post->dislikes+1;
                }
        }
        $vote->like=$user_like;
        $vote->dislike=$user_dislike;
        $vote->save();
        $post->save();
        event(new NewVote($vote));

        return 'Vote changed';
      }
      else{
          $vote=new Vote;
          if($type === 'like'){
            $vote->like=1;
            $vote->dislike=0;
            $vote->post_id=$id;
            $vote->user_id=$user;
            $post->likes=$post->likes+1;
          }else{
            $vote->like=0;
            $vote->dislike=1;
            $vote->post_id=$id;
            $vote->user_id=$user;
            $post->dislikes=$post->dislikes+1;
          }
          $vote->save();
          $post->save();

          if($post->user_id !== auth()->user()->id){
            $userIDD=User::findOrFail($post->user_id);
            $userIDD->notify(new VotedOnPostNotification(new VotedOnPostModel(auth()->user(), $type, $post->id)));
            }

          event(new NewVote($vote));


          return 'Vote saved';
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
