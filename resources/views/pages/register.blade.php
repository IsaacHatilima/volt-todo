<?php

use Livewire\Volt\Component;
use function Laravel\Folio\name;

name('register');
new class extends Component {

} ?>

<x-layouts.guest>
    @volt()
        <x-card>
            <x-auth-card-title/>
            <form>
                <x-text-input name="First Name" id="first_name" wire:model="first_name" :messages="$errors->get('first_name')" />
                <x-text-input name="Last Name" id="last_name" wire:model="last_name" :messages="$errors->get('last_name')" />
                <x-text-input name="E-Mail" id="email" wire:model.live="email" :messages="$errors->get('email')" />
                <x-password-input name="Password" id="password" wire:model.live="password" :messages="$errors->get('password')" />
                <x-password-input name="Confirm Password" id="password_confirmation" wire:model.live="password_confirmation" :messages="$errors->get('password_confirmation')" />

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
                    <a href="{{ route('google.redirect') }}" class="flex justify-center w-full p-2 py-3 m-1 duration-300 ease-in-out rounded-lg shadow-lg hover:scale-105 dark:bg-dark-background">
                        <img class="max-w-[25px]" src="https://ucarecdn.com/8f25a2ba-bdcf-4ff1-b596-088f330416ef/"
                            alt="Google" />
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
            </form>
        </x-card>
    @endvolt
</x-layouts.guest>

