<?php

namespace App\Observers;

use App\User;

class UserObserver
{
  /**
   * Handle to the User "created" event.
   *
   * @param  \App\User  $user
   * @return void
   */
  public function creating(User $user)
  {
      $user->api_token=bin2hex(openssl_random_pseudo_bytes(30));
      $user->profile_pic='default.png';
      $user->profile_bio='Just another pleb.';
      $user->asked=0;
  }

    /**
     * Handle to the User "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }
}
