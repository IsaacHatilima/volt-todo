<?php

use App\Models\User;
use Carbon\Carbon;
use Livewire\Volt\Component;
use Illuminate\Http\Request;
use function Laravel\Folio\name;

name('accounts-activation');
new class extends Component {
    public string $token;
    public int $tokenState;

    public function mount(Request $request): void
    {
        // $tokenState=0 => Valid Token or already verified
        // $tokenState=1 => No Token
        // $tokenState=2 => Expired Token
        // $tokenState=3 => Invalid Token
        $this->token = $request->query('token');

        if (!$this->token) {
            $this->tokenState = 1;
            return;
        }

        // Example: Decrypt and process the token
        try {
            $data = json_decode(Crypt::decryptString($this->token), true);
            // Check if token is expired
            $expiresAt = Carbon::parse($data['expires_at']);

            if (Carbon::now()->gt($expiresAt)) {
                $this->tokenState = 2; // Token has expired
                return;
            }

            $user = User::firstWhere('email', $data['email']);

            if (!$user) {
                $this->tokenState = 3; // Invalid token or user not found
                return;
            }

            if ($user->email_verified_at != null) {
                $this->tokenState = 0; // User already verified so token is invalid
            }

            $user->update([
                'email_verified_at' => now(),
            ]);

            $this->tokenState = 0; // Token is valid and user is verified

            Auth::loginUsingId($user->id);

            $this->redirectRoute('home');

        } catch (Exception $e) {
            $this->tokenState = 3; // An error occurred
        }

    }
} ?>

<x-layouts.guest>
    @volt()
    <div class="flex flex-col items-center">
        @if($this->tokenState == 0)
            <x-alert type="success" error="Email Verified."/>
        @elseif($this->tokenState == 1)
            <x-alert type="warning" error="Token Not Provided."/>
            <x-button tag="a" href="/" rounded="md" color="info" size="md" class="w-1/2 mt-4">
                <x-heroicon-s-arrow-left-circle class="w-6 h-6 mr-2"/>
                Back To Login
            </x-button>
        @elseif($this->tokenState == 2)
            <x-alert type="warning" error="Oops, you are late to the party. Token Expired."/>
            <x-button tag="button" rounded="md" color="primary" size="md" class="w-1/2 mt-4">
                Request New Token
                <x-heroicon-s-arrow-right-circle class="w-6 h-6 ml-2"/>
            </x-button>
        @else
            <x-alert type="warning" error="Oh Oh'? Invalid Token."/>
            <x-button tag="a" href="/" rounded="md" color="info" size="md" class="w-1/2 mt-4">
                <x-heroicon-s-arrow-left-circle class="w-6 h-6 mr-2"/>
                Back To Login
            </x-button>
        @endif
    </div>
    @endvolt

</x-layouts.guest>
