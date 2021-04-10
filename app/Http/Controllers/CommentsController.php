<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use App\User;
use App\Http\Resources\CommentResource;
use App\Http\Requests;
use App\Events\NewComment;
use App\Events\UpdatedComment;
use App\Events\UpdateCommentCount;
use App\Notifications\CommentedOnPostNotification;
use App\NotificationModels\CommentedOnPostModel;

class CommentsController extends Controller
{
  //TODO:Maybe add a parsing function for links
  //TODO: Delete all comments form a user function
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $comments=Comment::where('post_id',$id)->orderBy('created_at','desc')->get();
        return CommentResource::collection($comments);
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
          'post_id'=>'required',
          'postComment'=>'required',
        ]);
        $comment=new Comment;
        $comment->post_id=$request->input('post_id');
        $comment->commentBody=$request->input('postComment');
        $comment->user_id=auth()->user()->id;
        $comment->save();
        $posts=Post::where('id',$request->input('post_id'))->get();
        $post=$posts[0];
        if(!empty($post)){
          $post->comments=$post->comments+1;
          $post->save();
        }

        if($post->user_id !== auth()->user()->id){
        $user=User::findOrFail($post->user_id);
        $user->notify(new CommentedOnPostNotification(new CommentedOnPostModel(auth()->user(),$post->id)));
        }
        event(new NewComment($comment));
        event(new UpdateCommentCount($post));

        return 'Comment saved';
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
      $comment=Comment::find($id)->get();
      if(empty($comment)){
        return 'No comment with that id';
      }
      return $comment;
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
      $this->validate($request,[
        'updateComment'=>'required',
      ]);
      $comment=Comment::findOrFail($id);
      if(empty($comment)){
        return 'No comment with that id';
      }
      if($comment->user_id !== auth()->user()->id){
        return 'An error has ocurred';
      }
      $comment->commentBody=$request->input('updateComment');
      $comment->save();

        event(new UpdatedComment($comment));

      return 'comment has been updated';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $comment=Comment::findOrFail($id);
      if($comment->user_id === auth()->user()->id){
          $post=Post::findOrFail($comment->post_id);
          $post->comments=$post->comments-1;
          $post->save();
          $comment->delete();
      return 'comment deleted';
    }
    return 'An error has ocurred';
    }
}
