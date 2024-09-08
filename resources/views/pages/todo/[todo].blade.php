<?php

use App\Models\Task;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;
use Usernotnull\Toast\Concerns\WireToast;
use function Laravel\Folio\name;
use function Laravel\Folio\{middleware};

name('details');
middleware(['auth']);
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

    #[Computed]
    public function tasks()
    {
        return auth()->user()->todoTasks;;
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|min:3',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $entry = auth()->user()->todoTasks()->create(
            [
                'name' => ucwords($this->name),
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'user_id' => auth()->user()->id,
                'todo_id' => $this->todo->id
            ]
        );

        $this->reset(['name', 'start_date', 'end_date']);

        toast()
            ->success('Task Created!')
            ->push();
    }

    public function update(Task $task): void
    {
        if (!Gate::allows('update', $task)) {
            toast()
                ->danger('Not Allowed!')
                ->push();
        }

        $task->update([
            'name' => ucwords($this->name),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ]);

        $this->reset(['name']);
        $this->end_date = date("d-m-Y");
        $this->start_date = date("d-m-Y");

        toast()
            ->success('Task Updated!')
            ->push();
    }

    public function edit(Task $task): void
    {
        $this->id = $task->public_id;
        $this->name = $task->name;
        $this->end_date = date("d-m-Y", strtotime($task->end_date));
        $this->start_date = date("d-m-Y", strtotime($task->start_date));
        $this->isUpdating = true;
    }

    public function delete(Task $task): void
    {
        if (!Gate::allows('update', $task)) {
            toast()
                ->danger('Not Allowed!')
                ->push();
        }

        $task->delete();

        toast()
            ->success('Task Deleted!')
            ->push();
    }

} ?>

<x-layouts.app>
    @volt()
    @can('view', $todo)
        <div>
            <x-card>
                <h1 class="text-2xl text-black font-bold">
                    {{ $todo->name }}
                </h1>
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
                <div class="h-screen overflow-y-auto">
                    @foreach($this->tasks as $task)
                        <x-card class="{{ $loop->first ? '' : 'mt-2' }}">
                            <h1 class="text-black text-2xl font-bold flex items-center">
                                <a href="todo/{{ $task->public_id }}">{{ $task->name }}</a>
                                <x-badge
                                    state="{{ $task->status == 'Pending' ? 'yellow' : ($task->status == 'In Progress' ? 'blue' : 'green') }}"
                                    status="{{ $task->status }}"/>
                            </h1>

                            <div class="flex justify-between bg-gray-50">
                                <h1>From: {{ date("d-m-Y", strtotime($task->start_date)) }}</h1>
                                <h1>To: {{ date("d-m-Y", strtotime($task->end_date)) }}</h1>
                            </div>
                            <div class="flex justify-between mt-2">
                                <x-button wire:click="delete('{{$task->public_id}}')" rounded="md" color="danger" size="md"
                                          class="w-40">
                                    Delete
                                </x-button>
                                <x-button wire:click="edit('{{$task->public_id}}')" rounded="md" color="primary" size="md"
                                          class="w-40">
                                    Update
                                </x-button>
                            </div>
                        </x-card>
                    @endforeach
                </div>
            </div>

        </div>
    @else
        <x-card>
            <p class="text-2xl text-black font-bold">You are not authorized to view this todo.</p>
        </x-card>
    @endcan

    @endvolt
</x-layouts.app>
