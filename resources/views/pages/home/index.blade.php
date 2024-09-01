<?php

use Livewire\Volt\Component;
use function Laravel\Folio\name;
use function Laravel\Folio\{middleware};

middleware(['auth']);
name('home');
new class extends Component {

} ?>

<x-layouts.app>
    @volt()
        <div class="grid md:grid-cols-3 gap-2">
            <x-card>
                <h1>Todo</h1>
            </x-card>
            <x-card>
                <h1>Todo</h1>
            </x-card>
            <x-card>
                <h1>Todo</h1>
            </x-card>

        </div>
    @endvolt
</x-layouts.app>
