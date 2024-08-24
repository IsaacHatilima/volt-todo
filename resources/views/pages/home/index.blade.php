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
            @for ($i = 0; $i < 550; $i++)
                <h1>Hello</h1>
            @endfor

        </div>
    @endvolt
</x-layouts.app>
~
