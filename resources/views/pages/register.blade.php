<?php

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use function Laravel\Folio\name;

name('register');
new class extends Component {
    #[Validate('required|string|min:5', as: 'First Name')]
    public string $first_name;

    #[Validate('required|string|min:5', as: 'First Name')]
    public string $last_name;

    #[Validate('required|email|min:5|unique:users,email', as: 'E-Mail')]
    public string $email;

    #[Validate('required', message: '→ Password is required')]
    #[Validate('min:8', message: '→ Password is should be at least 8 characters')]
    #[Validate('regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@?]).*$/', message: '→ Password should contain a number, lower and upper case letter and special character (!$#%@?)')]
    public string $password;

    #[Validate('required', message: '→ Confirm Password is required')]
    #[Validate('same:password', message: '→ Passwords do not match')]
    public string $password_confirmation;

    public bool $created = false;

    public function register():void
    {
        $this->validate();

        $user = User::create(
            [
                'email' => $this->email,
                'password' => $this->password,
                'social_password' => false
            ]
        );

        $user->profile()->create([
            'user_id' => $user->id,
            'first_name' => ucwords($this->first_name),
            'last_name' => ucwords($this->last_name)
        ]);

        $this->created = true;
        $this->dispatch('account-created');
    }
} ?>

<x-layouts.guest>
    @volt()
    <x-card>
        <x-auth-card-title/>
        @if($this->created)
            <x-alert type="success" error="Account Created. We sent you a confirmation E-Mail." />
        @endif

            <x-text-input name="First Name" id="first_name" wire:model="first_name"
                          :messages="$errors->get('first_name')"/>
            <x-text-input name="Last Name" id="last_name" wire:model="last_name" :messages="$errors->get('last_name')"/>
            <x-text-input name="E-Mail" id="email" wire:model.live="email" :messages="$errors->get('email')"/>
            <x-password-input name="Password" id="password" wire:model.live="password"
                              :messages="$errors->get('password')"/>
            <x-password-input name="Confirm Password" id="password_confirmation" wire:model.live="password_confirmation"
                              :messages="$errors->get('password_confirmation')"/>

            <div class="flex justify-between w-full">
                <x-button tag="a" href="/" rounded="md" color="info" size="md" class="w-1/2 mr-2">
                    <x-heroicon-s-arrow-left-circle class="w-6 h-6 mr-2"/>
                    Back To Login
                </x-button>
                <x-button tag="button" wire:click="register" rounded="md" color="primary" size="md" class="w-1/2">
                    Register
                    <x-heroicon-s-arrow-right-circle class="w-6 h-6 ml-2"/>
                </x-button>
            </div>
            @if ($errors->get('error'))
                <ul class="my-2 space-y-1 text-red-400 text-md'">
                    @foreach ((array) $errors->get('error') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="flex items-center w-full gap-2 py-6 text-sm text-slate-600">
                <div class="w-full h-px bg-slate-200"></div>
                OR
                <div class="w-full h-px bg-slate-200"></div>
            </div>

            <div id="third-party-auth" class="flex flex-wrap items-center justify-center mt-5">
                <a href="{{ route('google.redirect') }}"
                   class="flex justify-center w-full p-2 py-3 m-1 duration-300 ease-in-out rounded-lg shadow-lg hover:scale-105 dark:bg-dark-background">
                    <img class="max-w-[25px]" src="https://ucarecdn.com/8f25a2ba-bdcf-4ff1-b596-088f330416ef/"
                         alt="Google"/>
                </a>
                {{-- <a href="#" class="flex justify-center w-1/4 p-2 py-3 m-1 duration-300 ease-in-out rounded-lg shadow-lg hover:scale-105 dark:bg-dark-background">
                    <img class="max-w-[25px]" src="https://ucarecdn.com/6f56c0f1-c9c0-4d72-b44d-51a79ff38ea9/"
                        alt="Facebook" />
                </a>
                <a href="#" class="flex justify-center w-1/4 p-2 py-3 m-1 duration-300 ease-in-out rounded-lg shadow-lg hover:scale-105 dark:bg-dark-background">
                    <img class="max-w-[25px]" src="https://ucarecdn.com/3277d952-8e21-4aad-a2b7-d484dad531fb/"
                        alt="apple" />
                </a> --}}
            </div>
    </x-card>
    @endvolt

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('account-created', function () {
                setTimeout(function () {
                    window.location.href = "{{ route('login') }}";
                }, 2000); // 2 seconds delay before redirect
            });
        });
    </script>

</x-layouts.guest>

