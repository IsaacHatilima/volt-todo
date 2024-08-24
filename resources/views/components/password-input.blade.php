@props(['disabled' => false, 'name', 'id', 'messages' =>[]])

<label class="w-full form-control">
    <div class="label">
        <span class="text-black label-text dark:text-gray-300"> {{ $name }} </span>
    </div>

    <div class="relative flex-1 col-span-4" x-data="{ showPassword: false }">
        <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
            'class' => 'dark:bg-gray-900 text-black dark:text-gray-300
            rounded-md shadow-sm w-full ' . ($messages ? 'border-red-500 dark:border-red-500 focus:border-red-500 dark:focus:border-red-500 focus:ring-red-500 dark:focus:ring-red-500' : 'border-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600'),
        ]) !!}
                name="{{ strtolower($id) }}"
                id="{{ strtolower($id) }}"
                :type="showPassword ? 'text' : 'password'" />

        <span class="absolute inset-y-0 right-0 flex items-center pr-3 dark:text-white" @click="showPassword = !showPassword">
            <template x-if="showPassword">
                <x-heroicon-o-eye class="w-6 h-6"/>
            </template>
            <template x-if="!showPassword">
                <x-heroicon-o-eye-slash class="w-6 h-6"/>
            </template>
        </span>
    </div>

    <div class="label">
        @if ($messages)
            <ul {{ $attributes->merge(['class' => 'text-sm text-red-400 dark:text-red-400 space-y-1']) }}>
                @foreach ((array) $messages as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</label>
