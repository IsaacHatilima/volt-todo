<?php

use Livewire\Volt\Component;
use Usernotnull\Toast\Concerns\WireToast;

new class extends Component {
    use WireToast;

    public function enable_2fa(): void
    {
        auth()->user()->update([
            'enabled_2fa' => !auth()->user()->enabled_2fa
        ]);

        toast()
            ->success('2FA Updated!')
            ->push();
    }
}

?>


<div>
    <x-card>
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-black text-black dark:text-white">2FA Manager</h1>
            <x-heroicon-c-finger-print class="h-8 w-8 text-teal-600"/>
        </div>
        <div class="flex justify-center mt-4">
            @if (!auth()->user()->enabled_2fa)

                <x-button tag="button" wire:click="enable_2fa()" rounded="md" color="primary" size="md" class="w-60">
                    Activate 2FA
                    <x-heroicon-s-arrow-right-circle class="w-6 h-6 ml-2"/>
                </x-button>
            @else
                <x-button tag="button" wire:click="enable_2fa()" rounded="md" color="danger" size="md" class="w-60">
                    Deactivate 2FA
                    <x-heroicon-s-arrow-right-circle class="w-6 h-6 ml-2"/>
                </x-button>
            @endif
        </div>
    </x-card>
</div>
