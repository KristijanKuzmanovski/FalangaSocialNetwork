@extends('layouts.app')

@section('content')

  <chat api_token="{{Auth::user()->api_token}}" username="{{Auth::user()->name}}" user_id="{{Auth::user()->id}}"></chat>

@endsection
