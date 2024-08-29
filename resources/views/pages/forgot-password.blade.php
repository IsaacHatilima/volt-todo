<?php

use App\Mail\RequestPasswordReset;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use App\Models\User;
use function Laravel\Folio\name;

name('forgot.password');
new class extends Component {
    #[Validate('required|email', as: 'E-Mail')]
    public string $email;

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
        return url('/set-password?token='.urlencode($token));
    }

    public function requestPasswordToken()
    {
        $this->validate();

        $user = User::firstWhere('email', $this->email);

        $this->reset();

        if(!$user) {
            return back()->with(['error' => 'If your provided a valid email, we sent you a password reset link.']);
        }

        $url = $this->createActivationToken($user->email);
        Mail::to($user->email)->send(new RequestPasswordReset($user, $url));
        $this->reset();
        return back()->with(['error' => 'If your provided a valid email, we sent you a password reset link.']);

    }

} ?>

<x-layouts.guest>
    @volt()
    <x-card>
        <x-auth-card-title/>
        <x-alert type="success" error="{{ session('error') }}"/>
        <x-text-input name="Email" id="email" wire:model="email" :messages="$errors->get('email')" autocomplete="email"/>

        <x-button tag="button" wire:click="requestPasswordToken" rounded="md" color="primary" size="md" class="w-full">
            Reset Password
            <x-heroicon-s-arrow-right-circle class="w-6 h-6 ml-2"/>
        </x-button>
        <x-button tag="a" href="/" rounded="md" color="info" size="md" class="w-full mt-3">
            <x-heroicon-s-arrow-left-circle class="w-6 h-6 mr-2"/>
            Back To Login
        </x-button>
    </x-card>
    @endvolt
</x-layouts.guest>

