<?php

use App\Models\Todo;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;
use Usernotnull\Toast\Concerns\WireToast;
use function Laravel\Folio\name;
use function Laravel\Folio\{middleware};

name('todo.index');
middleware(['auth']);
new class extends Component {
    use WireToast;

    public string $id;
    public string $name;
    public string $start_date;
    public string $end_date;
    public bool $isUpdating = false;

    #[Computed]
    public function todos()
    {
        return auth()->user()->todos;
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|min:3',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $entry = auth()->user()->todos()->create(
            [
                'name' => ucwords($this->name),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date
            ]
        );

        $this->reset(['name', 'start_date', 'end_date']);
        toast()
            ->success('Todo Created!')
            ->push();
    }

    public function mount(): void
    {
        $this->end_date = date("d-m-Y");
        $this->start_date = date("d-m-Y");
    }

    public function update(Todo $todo): void
    {
        $todo->update([
            'name' => ucwords($this->name),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ]);

        $this->reset(['name']);
        $this->end_date = date("d-m-Y");
        $this->start_date = date("d-m-Y");

        toast()
            ->success('Todo Updated!')
            ->push();
    }

    public function edit(Todo $todo): void
    {
        $this->id = $todo->public_id;
        $this->name = $todo->name;
        $this->end_date = date("d-m-Y", strtotime($todo->end_date));
        $this->start_date = date("d-m-Y", strtotime($todo->start_date));
        $this->isUpdating = true;
    }

    public function delete(Todo $todo): void
    {
        $todo->delete();

        toast()
            ->success('Todo Deleted!')
            ->push();
    }
} ?>

<x-layouts.app>
    @volt()
    <div class="grid md:grid-cols-2 gap-2">
        <div class="">
            <x-card>
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-black text-black dark:text-white">Add Todo</h1>
                    <x-heroicon-s-user-circle class="h-8 w-8 text-sky-500"/>
                </div>

                <div>
                    <form>
                        <x-text-input name="Todo Name" id="name" wire:model="name" :messages="$errors->get('name')"/>

                        <x-date name="Start Date" id="start_date" wire:model="start_date" :messages="$errors->get('start_date')"/>

                        <x-date name="End Date" id="end_date" wire:model="end_date" :messages="$errors->get('end_date')"/>

                        <div class="flex justify-end">
                            @if(!$this->isUpdating)
                                <x-button wire:click="save()" rounded="md" color="primary" size="md" class="w-40">
                                    Save
                                    <x-heroicon-s-arrow-right-circle class="w-6 h-6 ml-2"/>
                                </x-button>
                            @else
                                <x-button wire:click="update('{{ $this->id }}')" rounded="md" color="primary" size="md" class="w-40">
                                    Update
                                    <x-heroicon-s-arrow-right-circle class="w-6 h-6 ml-2"/>
                                </x-button>
                            @endif

                        </div>
                    </form>

                </div>

            </x-card>
        </div>
        <div class="h-screen overflow-y-auto">
            @foreach($this->todos as $todo)
                <x-card class="{{ $loop->first ? '' : 'mt-2' }}">
                    <h1 class="text-black text-2xl font-bold flex items-center">
                        <a href="todo/{{ $todo->public_id }}">{{ $todo->name }}</a>
                        <x-badge state="{{ $todo->status == 'Pending' ? 'yellow' : ($todo->status == 'In Progress' ? 'blue' : 'green') }}" status="{{ $todo->status }}"/>
                    </h1>

                    <div class="flex justify-between bg-gray-50">
                        <h1>From: {{ date("d-m-Y", strtotime($todo->start_date)) }}</h1>
                        <h1>To: {{ date("d-m-Y", strtotime($todo->end_date)) }}</h1>
                    </div>
                    <div class="flex justify-between mt-2">
                        <x-button wire:click="delete('{{$todo->public_id}}')" rounded="md" color="danger" size="md" class="w-40">
                            Delete
                        </x-button>
                        <x-button wire:click="edit('{{$todo->public_id}}')" rounded="md" color="primary" size="md" class="w-40">
                            Update
                        </x-button>
                    </div>
                </x-card>
            @endforeach
        </div>
    </div>
    @endvolt
</x-layouts.app>
