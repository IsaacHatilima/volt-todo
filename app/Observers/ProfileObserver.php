<?php

namespace App\Observers;

use App\Mail\AccountWithSocialCreated;
use App\Models\Profile;
use Illuminate\Support\Facades\Mail;

class ProfileObserver
{
    /**
     * Handle the Profile "created" event.
     */
    public function created(Profile $profile): void
    {
        if($profile->user->email_verified_at) {
            Mail::to($profile->user->email)->send(new AccountWithSocialCreated($profile));
        }
    }

    /**
     * Handle the Profile "updated" event.
     */
    public function updated(Profile $profile): void
    {
        //
    }

    /**
     * Handle the Profile "deleted" event.
     */
    public function deleted(Profile $profile): void
    {
        //
    }

    /**
     * Handle the Profile "restored" event.
     */
    public function restored(Profile $profile): void
    {
        //
    }

    /**
     * Handle the Profile "force deleted" event.
     */
    public function forceDeleted(Profile $profile): void
    {
        //
    }
}
