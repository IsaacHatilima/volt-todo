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
            @foreach(auth()->user()->todo as $todo)
                <x-card class="{{ $loop->first ? '' : 'mt-2' }}">
                    <h1 class="text-black text-2xl font-bold flex items-center">
                        <a href="todo/{{ $todo->public_id }}">{{ $todo->name }}</a>

                        <x-badge state="{{ $todo->status == 'Pending' ? 'yellow' : ($todo->status == 'In Progress' ? 'blue' : 'green') }}" status="{{ $todo->status }}"/>
                    </h1>

                    <div class="flex justify-between bg-gray-50">
                        <h1>From: {{ date("d-m-Y", strtotime($todo->start_date)) }}</h1>
                        <h1>To: {{ date("d-m-Y", strtotime($todo->end_date)) }}</h1>
                    </div>
                </x-card>
            @endforeach
        </div>
    @endvolt
</x-layouts.app>
