<?php

use Livewire\Volt\Component;
use function Laravel\Folio\name;

name('forgot.password');
new class extends Component {

} ?>

<x-layouts.guest>
    @volt()
        <x-card>
            <x-auth-card-title/>
            <form action="/login" method="POST">
                @csrf
                <x-text-input wire:model="email" name="Email" :messages="$errors->get('email')" />

                <x-button submit="true" rounded="md" color="primary" size="md" class="w-full">
                    Reset Password
                </x-button>
            </form>
        </x-card>
    @endvolt
</x-layouts.guest>

