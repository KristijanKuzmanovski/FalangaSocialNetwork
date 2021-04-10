<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function getNotifications(){
      return auth()->user()->notifications;
    }

    public function markAsRead(){
      foreach (auth()->user()->unreadNotifications as $notification) {
          $notification->markAsRead();
      }
      return "Marked as read";
    }

}
