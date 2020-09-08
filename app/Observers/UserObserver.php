<?php

namespace App\Observers;

use App\User;

// facades
use App\Facades\FileFacade;

class UserObserver
{

    public function created(User $user)
    {
        //
    }


    public function updating(User $user)
    {

    }


    public function deleted(User $user)
    {
        $user->update(['image_id' => null]);
    }


    public function restored(User $user)
    {
        //
    }


    public function forceDeleted(User $user)
    {
        //
    }
}
