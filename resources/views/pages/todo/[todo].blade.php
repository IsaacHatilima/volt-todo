<?php

use Livewire\Volt\Component;
use Usernotnull\Toast\Concerns\WireToast;
use function Laravel\Folio\name;

name('details');
new class extends Component {
    use WireToast;

    public string $id;
    public string $name;
    public string $start_date;
    public string $end_date;
    public bool $isUpdating = false;
    public object $todo;

    public function mount(): void
    {
        $this->end_date = date("d-m-Y");
        $this->start_date = date("d-m-Y");
    }

} ?>

<x-layouts.app>
    @volt()
    <div>
        <x-card>
            {{ $todo->name }}
        </x-card>

        <div class="grid md:grid-cols-2 gap-2 mt-4">
            <div class="">
                <x-card>
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-black text-black dark:text-white">Add Task</h1>
                        <x-heroicon-s-user-circle class="h-8 w-8 text-sky-500"/>
                    </div>

                    <div>
                        <form>
                            <x-text-input name="Todo Name" id="name" wire:model="name"
                                          :messages="$errors->get('name')"/>

                            <x-date name="Start Date" id="start_date" wire:model="start_date"
                                    :messages="$errors->get('start_date')"/>

                            <x-date name="End Date" id="end_date" wire:model="end_date"
                                    :messages="$errors->get('end_date')"/>

                            <div class="flex justify-end">
                                @if(!$this->isUpdating)
                                    <x-button wire:click="save()" rounded="md" color="primary" size="md" class="w-40">
                                        Save
                                        <x-heroicon-s-arrow-right-circle class="w-6 h-6 ml-2"/>
                                    </x-button>
                                @else
                                    <x-button wire:click="update('{{ $this->id }}')" rounded="md" color="primary"
                                              size="md" class="w-40">
                                        Update
                                        <x-heroicon-s-arrow-right-circle class="w-6 h-6 ml-2"/>
                                    </x-button>
                                @endif

                            </div>
                        </form>

                    </div>

                </x-card>
            </div>
        </div>
    </div>
    @endvolt
</x-layouts.app>
