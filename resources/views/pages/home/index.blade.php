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
        <div>
            hello
        </div>
    @endvolt
</x-layouts.app>
~
