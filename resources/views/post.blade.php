@extends('layouts.app')

@section('content')
<single-post user='{{Auth::user()->id}}' url='{{url('/')}}' api_token='{{Auth::user()->api_token}}' img='{{$data->profile_pic}}' username='{{Auth::user()->name}}' post_created_at='{{$data->created_at}}' likes='{{$data->likes}}' dislikes='{{$data->dislikes}}' comments='{{$data->comments}}' post_body='{{$data->postBody}}' post_user_id='{{$data->user_id}}' post_id='{{$data->id}}' ></single-post>
@endsection
