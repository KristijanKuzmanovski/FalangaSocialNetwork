<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Image;
use App\User;
use File;
use App\Post;
class UserProfileController extends Controller
{
    public function profile($id){

      $user=User::findOrFail($id);
      return view('profile')->with('user',$user);
    }

    public function enrich(Request $req){
      $user=Auth::user();
      $imgData=$req->get('img');
      $img=base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$imgData));
      $name=time().'.png';
      Image::make($img)->save(public_path('images/profiles/'.$name));
      if(!empty($req->input('bio'))){
      $user->profile_bio=$req->input('bio');
      }
      $user->profile_pic=$name;
      $user->asked="1";
      $user->save();

    }

    public function asked(Request $req){
      $user=Auth::user();
      $user->asked="1";
      $user->save();
    }

    public function edit(Request $req,$id){

      if(Auth::user()->id === $id){
      return 'Error';
    }
        $user=Auth::user();
        if($user->profile_pic !== 'default.png'){
        $image_path = public_path('images/profiles/'.$user->profile_pic);
        if(File::exists($image_path)) {
          File::delete($image_path);
          }
        }
        $imgData=$req->get('img');
        $img=base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$imgData));
        $name=time().'.png';
        Image::make($img)->save(public_path('images/profiles/'.$name));
        if(empty($req->input('bio'))){
        $user->profile_bio='Just another pleb.';
        }else{
        $user->profile_bio=$req->input('bio');
        }
        $user->profile_pic=$name;
        $user->save();
    }
    public function historyPosts(){
      return Post::where("user_id",Auth()->user()->id)->orderBy('created_at','desc')->get();
    }
}
