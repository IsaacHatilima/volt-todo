<?php

use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Usernotnull\Toast\Concerns\WireToast;

new class extends Component {
    use WireToast;

    public string $first_name;
    public string $last_name;
    public string $email;
    public string $gender;
    public string $date_of_birth;

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'min:5',
                'email',
                Rule::unique('users')->ignore(auth()->user()),
            ],
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required|string',
            'date_of_birth' => 'required|date',
        ];
    }

    public function mount(): void
    {
        $this->first_name = auth()->user()->profile->first_name;
        $this->last_name = auth()->user()->profile->last_name;
        $this->email = auth()->user()->email;
        $this->gender = auth()->user()->profile->gender ? auth()->user()->profile->gender : '';
        $this->date_of_birth = auth()->user()->profile->date_of_birth ? auth()->user()->profile->date_of_birth : '';
    }

    public function save(): void
    {
        $this->validate();

        auth()->user()->update([
            'email' => $this->email,
        ]);

        auth()->user()->profile->update([
            'first_name' => ucwords($this->first_name),
            'last_name' => ucwords($this->last_name),
            'gender' => ucwords($this->gender),
            'date_of_birth' => ucwords($this->date_of_birth)
        ]);

        toast()
            ->success('Profile Updated!')
            ->push();
    }
}
?>


<div>
    <x-card>
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-black text-black dark:text-white">Profile Manager</h1>
            <x-heroicon-s-user-circle class="h-8 w-8 text-sky-500"/>
        </div>

        <div>
            <x-text-input name="First Name" id="first_name" wire:model="first_name"
                          :messages="$errors->get('first_name')"/>
            <x-text-input name="Last Name" id="last_name" wire:model="last_name" :messages="$errors->get('last_name')"/>
            <x-text-input name="E-Mail" id="email" wire:model.live="email" :messages="$errors->get('email')"/>
            <x-select name="Gender" id="gender" wire:model="gender" :messages="$errors->get('gender')">
                <option value="female">Female</option>
                <option value="male">Male</option>
            </x-select>
            <x-date  name="Date" id="date_of_birth" wire:model="date_of_birth" :messages="$errors->get('date_of_birth')"/>
            <div class="flex justify-end">
                <x-button tag="button" wire:click="save()" rounded="md" color="primary" size="md" class="w-40">
                    Save
                    <x-heroicon-s-arrow-right-circle class="w-6 h-6 ml-2"/>
                </x-button>
            </div>
        </div>

    </x-card>
</div>
