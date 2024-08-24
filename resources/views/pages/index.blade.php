<?php

use Livewire\Volt\Component;
use function Laravel\Folio\name;

name('login');
new class extends Component {

} ?>

<x-layouts.guest>
    @volt()
        <x-card>
            <x-auth-card-title/>
            <x-alert type="warning" error="{{ session('invalid_user') }}" />
            <form>
                @csrf
                <x-text-input value="isaachatilima@gmail.com" name="Email" id="email" :messages="$errors->get('email')" required />
                <x-password-input name="Password" value="Password1#" id="password" :messages="$errors->get('password')" required />

                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember_me" type="checkbox"
                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="remember_me" class="block ml-2 text-sm dark:text-dark-text">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a class="transition-all duration-100 ease-in-out group text-gray-950" href="{{ route('forgot.password') }}">
                            <span
                                class="bg-left-bottom bg-gradient-to-r from-gray-950 to-gray-950 bg-[length:0%_2px] bg-no-repeat group-hover:bg-[length:100%_2px] transition-all duration-500 ease-out">
                                Forgot Password?
                            </span>
                        </a>
                    </div>
                </div>

                <x-button submit="true" rounded="md" color="primary" size="md" class="w-full">
                    Login
                    <x-heroicon-s-arrow-right-circle class="w-6 h-6 ml-2 hover:bg-red-500"/>
                </x-button>

                @if ($errors->get('error'))
                    <ul class="my-2 space-y-1 text-red-400 text-md'">
                        @foreach ((array) $errors->get('error') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @endif

                <div class="flex flex-col items-center justify-center mt-4 text-md">
                    <h3 class="dark:text-gray-300">
                        Don't have an account?
                        <a class="text-blue-400 transition-all duration-100 ease-in-out group" href="{{ route('register') }}">
                            <span
                                class="bg-left-bottom bg-gradient-to-r from-blue-400 to-blue-400 bg-[length:0%_2px] bg-no-repeat group-hover:bg-[length:100%_2px] transition-all duration-500 ease-out">
                                Sign Up
                            </span>
                        </a>
                    </h3>
                </div>

                <div class="flex items-center w-full gap-2 py-6 text-sm text-slate-600">
                    <div class="w-full h-px bg-slate-200"></div>
                    OR
                    <div class="w-full h-px bg-slate-200"></div>
                </div>

                <div id="third-party-auth" class="flex flex-wrap items-center justify-center">
                    <a href="{{ route('google.redirect') }}" class="flex justify-center w-full p-2 py-3 m-1 duration-300 ease-in-out rounded-lg shadow-lg hover:scale-105 dark:bg-dark-background">
                        <img class="max-w-[25px]" src="https://ucarecdn.com/8f25a2ba-bdcf-4ff1-b596-088f330416ef/"
                            alt="Google" />
                    </a>
                </div>
            </form>
        </x-card>
    @endvolt
</x-layouts.guest>
