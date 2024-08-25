<?php

namespace App\Observers;

use App\Mail\AccountCreated;
use App\Mail\AccountWithSocialCreated;
use App\Models\Profile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ProfileObserver
{
    private function createActivationToken($email): string
    {
        $randomString = Str::random(32);
        $expiresAt = Carbon::now()->addMinutes(30);

        // Prepare the token data
        $data = [
            'email' => $email,
            'expires_at' => $expiresAt->toDateTimeString(),
            'random_string' => $randomString,
        ];

        // Encrypt the token data
        $token = Crypt::encryptString(json_encode($data));

        // Create the activation link
        return url('/account-activation?token=' . urlencode($token));
    }
    /**
     * Handle the Profile "created" event.
     */
    public function created(Profile $profile): void
    {
        if($profile->user->email_verified_at) {
            Mail::to($profile->user->email)->send(new AccountWithSocialCreated($profile));
        }
        $url = $this->createActivationToken($profile->user->email);
        Mail::to($profile->user->email)->send(new AccountCreated($profile, $url));
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
}
