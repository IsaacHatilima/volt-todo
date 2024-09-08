<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Livewire\Features\SupportRedirects\Redirector;

new class extends Component {

    #[Validate('required', message: '→ Password is required')]
    public string $password;

    public bool $deleteToggle = false;

    public function delete_account()
    {
        if (Hash::check($this->password, auth()->user()->password)) {
            auth()->user()->delete();
            return redirect('/');
        } else {
            $this->addError('password', 'Invalid Password.');
            return;
        }
    }
}

?>


<div>
    <x-card>
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-black text-black dark:text-white">Delete Profile</h1>
            <x-heroicon-s-trash class="h-8 w-8 text-red-600"/>
        </div>
        <div>
            @if($this->deleteToggle)
                <x-password-input name="Password" id="password" wire:model.live="password"
                                  :messages="$errors->get('password')"/>
                <div class="flex justify-end">
                    <x-button tag="button" wire:click="delete_account()" rounded="md" color="danger" size="md" class="w-60">
                        Delete Account
                        <x-heroicon-s-arrow-right-circle class="w-6 h-6 ml-2"/>
                    </x-button>
                </div>
            @else
                <div class="flex justify-center mt-4">
                    <x-button tag="button" wire:click="$toggle('deleteToggle')" rounded="md" color="danger" size="md" class="w-60">
                        Delete Account
                        <x-heroicon-s-arrow-right-circle class="w-6 h-6 ml-2"/>
                    </x-button>
                </div>

            @endif

        </div>
    </x-card>
</div>
