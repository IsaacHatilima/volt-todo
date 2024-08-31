<?php

use App\Mail\SendAuthCode;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use function Laravel\Folio\name;

name('login');
new class extends Component {
    #[Validate('required|email', as: 'E-Mail')]
    public string $email;

    #[Validate('required|string', as: 'Password')]
    public string $password;

    public string $code;

    public bool $remember_me = false;

    public bool $has_2fa = false;

    public function mount()
    {
        $this->email = 'isaachatilima@gmail.com';
        $this->password = 'Password1#';
        if (auth()->user()) {
            $this->redirectRoute('home');
        }
    }


    public function signin()
    {
        $this->validate();

        $key = $this->email.'|'.request()->ip();

        // Check if the rate limit has been exceeded
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->with(['error' => 'Too many login attempts. Please try again in a few minutes.']);
        }

        // Attempt login
        $user = User::firstWhere('email', $this->email);

        if (!$user) {
            RateLimiter::hit($key); // Record a failed attempt
            return back()->with(['error' => 'Invalid credentials.']);
        }

        if (!Hash::check($this->password, $user->password)) {
            RateLimiter::hit($key); // Record a failed attempt
            return back()->with(['error' => 'Invalid credentials.']);
        }

        RateLimiter::clear($key); // Clear attempts on successful login

        if ($user->enabled_2fa) {
            $this->has_2fa = true;

            $code = Str::random(6);

            $user->update([
                'two_fa_code' => $code
            ]);

            Mail::to($user->email)->send(new SendAuthCode($user, $code));
        } else {
            Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me);
            $user = Auth::user();
            $user->update(['last_login' => now()]);
            $this->redirectRoute('home');
        }
    }

    public function two_fa_challenge()
    {
        $this->validate([
            'code' => 'required',
        ]);

        $user = User::firstWhere('two_fa_code', $this->code);

        if(!$user) {
            return back()->with(['error' => 'Invalid Code.']);
        }

        Auth::loginUsingId($user->id);
        $user->update([
            'last_login' => now(),
            'two_fa_code' => null
        ]);
        $this->redirectRoute('home');
    }
} ?>

<x-layouts.guest>
    @volt()
    <x-card>
        <x-auth-card-title/>
        <x-alert type="warning" error="{{session('error')}}"/>

        @if(!$this->has_2fa)
            <x-text-input name="Email" id="email" wire:model="email" :messages="$errors->get('email')"
                          required/>
            <x-password-input name="Password" id="password" wire:model="password" :messages="$errors->get('password')"
                              required/>

            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center">
                    <input id="remember_me" name="remember_me" wire:model="remember_me" type="checkbox"
                           class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="remember_me" class="block ml-2 text-sm dark:text-dark-text">
                        Remember me
                    </label>
                </div>

                <div class="text-sm">
                    <a class="transition-all duration-100 ease-in-out group text-gray-950"
                       href="{{ route('forgot.password') }}">
                        <span
                            class="bg-left-bottom bg-gradient-to-r from-gray-950 to-gray-950 bg-[length:0%_2px] bg-no-repeat group-hover:bg-[length:100%_2px] transition-all duration-500 ease-out">
                            Forgot Password?
                        </span>
                    </a>
                </div>
            </div>

            <x-button tag="button" wire:click="signin" rounded="md" color="primary" size="md" class="w-full">
                Login
                <x-heroicon-s-arrow-right-circle class="w-6 h-6 ml-2"/>
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
                    <a class="text-blue-400 transition-all duration-100 ease-in-out group"
                       href="{{ route('register') }}">
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
                <a href="{{ route('google.redirect') }}"
                   class="flex justify-center w-full p-2 py-3 m-1 duration-300 ease-in-out hover:scale-105 rounded-lg shadow-lg dark:bg-dark-background">
                    <img class="max-w-[25px]" src="https://ucarecdn.com/8f25a2ba-bdcf-4ff1-b596-088f330416ef/"
                         alt="Google"/>
                </a>
            </div>
        @else
            <h1>Please enter your 2FA Code to continue</h1>

            <x-text-input name="Code" id="code" wire:model="code" :messages="$errors->get('code')"/>

            <x-button tag="button" wire:click="two_fa_challenge()" rounded="md" color="primary" size="md"
                      class="w-full">
                Continue
                <x-heroicon-s-arrow-right-circle class="w-6 h-6 ml-2"/>
            </x-button>
        @endif


    </x-card>
    @endvolt
</x-layouts.guest>
