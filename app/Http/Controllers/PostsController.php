<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Vote;
use App\User;
use App\Comment;
use App\Http\Resources\PostResource;
use App\Http\Requests;
use App\Events\NewPost;
use App\Events\UpdatedPost;
use Illuminate\Support\Facades\Cache;
use App\Notifications\NewPostNotification;
use App\NotificationModels\PostNotificationModel;
use Illuminate\Support\Facades\Notification;

class PostsController extends Controller
{
  //TODO:Maybe add a parsing function for links
  //TODO: Delete all posts form a user function
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post=Post::orderBy('created_at','desc')->paginate(15);
        if(empty($post)){
          return 'No posts found';
        }

        //TODO:Create a view for post
        return PostResource::collection($post);
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
      $this->validate($request,['sendPost'=>'required']);
      $post=new Post;
      $post->postBody=$request->input('sendPost');
      $post->user_id=auth()->user()->id;
      $post->likes=0;
      $post->dislikes=0;
      $post->comments=0;
      $post->save();
      $users=User::where('id','<>',$post->user_id)->get();

      Notification::send($users, new NewPostNotification(new PostNotificationModel(auth()->user(),$post->id)));
      event(new NewPost($post));

      //TODO:Make the return ether to a view or a redirection
      return 'post has been saved';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $post=Post::findOrFail($id);
      $postR=new PostResource($post);
        return view('post')->with("data",$postR);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post=Post::findOrFail($id)->get();
        if(empty($post)){
          return 'No post with that id';
        }
        return new PostResource($post);
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
        $this->validate($request,['updatePost'=>'required']);
        $post=Post::findOrFail($id);
        if(empty($post)){
          return 'An error has ocurred';
        }
        if(!($post->user_id === auth()->user()->id)){
            return 'An error has ocurred';
          }
        $post->postBody=$request->input('updatePost');
        $post->save();
        //TODO:Maybe set an event to notfy when a post has been edited.

        event(new UpdatedPost($post));

        return 'post has been updated';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Post::findOrFail($id);
        if($post->user_id === auth()->user()->id){
        $votes=Vote::where("post_id",$post->id)->get();
        $comments=Comment::where("post_id",$post->id)->get();
        if(!empty($votes)){
          foreach ($votes as $vote) {
            $vote->delete();
          }
        }
        if(!empty($comments)){
          foreach ($comments as $comment) {
            $comment->delete();
          }
        }
        $post->delete();
        return 'post deleted';
      }
      return 'An error has ocurred';
    }
}
