<?php

use Livewire\Volt\Component;
use function Laravel\Folio\name;
use function Laravel\Folio\{middleware};

middleware(['auth']);
name('settings');
new class extends Component {

} ?>

<x-layouts.app>
    @volt()
        <div class="md:flex md:flex-col md:items-center">
            <div class="md:w-1/3 space-y-4">
                <livewire:components.profile.user-data/>

                <livewire:components.profile.password-manager/>

                <livewire:components.profile.2fa/>

                <livewire:components.profile.delete-profile/>
            </div>
        </div>
    @endvolt
</x-layouts.app>
