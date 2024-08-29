<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function Laravel\Folio\name;

name('set.password');
new class extends Component {
    public string $token;
    public string $alert;
    public bool $showForm = false;
    public bool $passwordSet = false;

    public $userObject;

    #[Validate('required', message: '→ Password is required')]
    #[Validate('min:8', message: '→ Password is should be at least 8 characters')]
    #[Validate('regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@?]).*$/', message: '→ Password should contain a number, lower and upper case letter and special character (!$#%@?)')]
    public string $password;

    #[Validate('required', message: '→ Confirm Password is required')]
    #[Validate('same:password', message: '→ Passwords do not match')]
    public string $password_confirmation;

    public function mount(Request $request): void
    {
        // $tokenState=0 => Valid Token or already verified
        // $tokenState=1 => No Token
        // $tokenState=2 => Expired Token
        // $tokenState=3 => Invalid Token
        $this->token = $request->query('token');

        if (!$this->token) {
            $this->alert = "Missing Token.";
            return;
        }

        // Example: Decrypt and process the token
        try {
            $data = json_decode(Crypt::decryptString($this->token), true);
            // Check if token is expired
            $expiresAt = Carbon::parse($data['expires_at']);

            if (Carbon::now()->gt($expiresAt)) {
                $this->alert = "Token has expired.";
                return;
            }

            $user = User::firstWhere('email', $data['email']);

            if (!$user) {
                $this->alert = "Invalid token or user not found.";
                return;
            }

            $this->userObject = $user;
            $this->showForm = true;

        } catch (Exception $e) {
            $this->alert = "Invalid Token Provided."; // An error occurred
        }
    }

    public function setPassword():void
    {
        $this->userObject->update([
            'password' => $this->password
        ]);

        $this->passwordSet = true;
        $this->reset(['password', 'password_confirmation']);
        $this->dispatch('password-updated');
    }
} ?>

<x-layouts.guest>
    @volt()
    <x-card>
        <x-auth-card-title/>
        @if(!$this->showForm)
            <x-alert type="warning" error="{{  $this->alert }}"/>
            <x-button tag="a" href="/" rounded="md" color="primary" size="md" class="w-full mt-2">
                <x-heroicon-s-arrow-left-circle class="w-6 h-6 mr-2"/>
                Request New Token
            </x-button>
        @else
            @if($this->passwordSet)
            <x-alert type="success" error="Password changed successfully."/>
            @endif
            <x-password-input name="Password" id="password" wire:model.live="password"
                              :messages="$errors->get('password')"/>
            <x-password-input name="Confirm Password" id="password_confirmation" wire:model.live="password_confirmation"
                              :messages="$errors->get('password_confirmation')"/>

            <x-button tag="button" wire:click="setPassword" rounded="md" color="primary" size="md" class="w-full">
                Set Password
                <x-heroicon-s-arrow-right-circle class="w-6 h-6 ml-2"/>
            </x-button>
        @endif
    </x-card>
    @endvolt

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('password-updated', function () {
                setTimeout(function () {
                    window.location.href = "{{ route('login') }}";
                }, 2000); // 2 seconds delay before redirect
            });
        });
    </script>
</x-layouts.guest>
