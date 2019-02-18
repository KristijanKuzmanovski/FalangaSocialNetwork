<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Http\Resources\MessageResource;
use App\Http\Resources\SeenResource;
use App\Http\Requests;
use App\Events\NewMessage;
use App\User;
class MessagesController extends Controller
{
  //TODO:Maybe add a parsing function for links
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages=Message::orderBy('created_at','desc')->paginate(10);
        if(empty($messages)){
          return 'No messages';
        }
        return MessageResource::collection($messages);
    }
    public function lastRead(){
        $users=User::all();

        if(empty($users)){
          return 'No messages';
        }
        elseif (count($users) === 1) {
          return new SeenResource($users[0]);
        }

        return SeenResource::collection($users);
    }
    public function hasRead(Request $request){
        $this->validate($request,[
        'message_id'=>'required',
        'user_id'=>'required'
      ]);
        if(auth()->user()->lastRead !== $request->input('message_id')){
           $id = User::findOrFail($request->input('user_id'));
           $id->lastRead=$request->input('message_id');
           $id->save();
        }
        return "Seen set";
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //npm install -D vue-template-compiler@latest
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
        'sendMessage'=>'required'
      ]);
      $message=new Message;
      $message->user_id=auth()->user()->id;
      $message->messageBody=$request->input('sendMessage');
      $message->created_at=date("Y-m-d H:i:s");
      $message->save();

      broadcast(new NewMessage($message));

      return 'Message saved';
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
