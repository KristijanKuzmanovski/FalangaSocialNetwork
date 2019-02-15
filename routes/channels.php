<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
 Broadcast::channel('FalangaChat', function ($user) {
     return ['id' => $user->id, 'name' => $user->name, 'pic' => "/images/profiles/".$user->profile_pic];
 });
Broadcast::channel('FalangaFeed', function ($user) {
    return ['id' => $user->id, 'name' => $user->name, 'pic' => "/images/profiles/".$user->profile_pic];
});
Broadcast::channel('FalangaComment.{id}', function ($user, $id) {
    return true;
});
