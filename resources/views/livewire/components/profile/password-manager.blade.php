<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Usernotnull\Toast\Concerns\WireToast;

new class extends Component {
    use WireToast;

    #[Validate('required', message: '→ Password is required')]
    #[Validate('min:8', message: '→ Password is should be at least 8 characters')]
    #[Validate('regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@?]).*$/', message: '→ Password should contain a number, lower and upper case letter and special character (!$#%@?)')]
    public string $password;

    #[Validate('required', message: '→ Confirm Password is required')]
    #[Validate('same:password', message: '→ Passwords do not match')]
    public string $password_confirmation;

    #[Validate('required', message: '→ Current Password is required')]
    public string $current_password;

    public function save(): void
    {
        $this->validate();

        if (!Hash::check($this->current_password, auth()->user()->password)) {
            $this->addError('current_password', 'Invalid Password.');
            return;
        }

        auth()->user()->update([
            'password' => $this->password
        ]);

        toast()
            ->success('Password Updated!')
            ->push();
    }
}

?>


<div>
    <x-card>
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-black text-black dark:text-white">Password Manager</h1>
            <x-heroicon-m-lock-closed class="h-8 w-8 text-amber-600"/>
        </div>

        <div>
            <x-password-input name="Current Password" id="current_password" wire:model.live="current_password"
                              :messages="$errors->get('current_password')"/>
            <x-password-input name="New Password" id="password" wire:model.live="password"
                              :messages="$errors->get('password')"/>
            <x-password-input name="Confirm Password" id="password_confirmation" wire:model.live="password_confirmation"
                              :messages="$errors->get('password_confirmation')"/>

            <div class="flex justify-end">
                <x-button tag="button" wire:click="save()" rounded="md" color="primary" size="md" class="w-60">
                    Change Password
                    <x-heroicon-s-arrow-right-circle class="w-6 h-6 ml-2"/>
                </x-button>
            </div>
        </div>
    </x-card>
</div>
