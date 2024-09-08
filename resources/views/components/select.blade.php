@props(['disabled' => false, 'name', 'id', 'messages' =>[]])

<div class="w-full form-control">
    <div class="label">
        <span class="text-black label-text dark:text-gray-300"> {{ $name }} </span>
    </div>

    <select name="{{ strtolower($id) }}" id="{{ strtolower($id) }}" {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge([
                'class' => 'bg-white dark:bg-gray-900 text-black dark:text-gray-300 select select-bordered
                rounded-md shadow-sm w-full ' . ($messages ? 'border-red-500 dark:border-red-500 focus:border-red-500 dark:focus:border-red-500 focus:ring-red-500 dark:focus:ring-red-500' : 'border-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600'),
            ]) }}>
        <option disabled selected>Who shot first?</option>
        {{ $slot }}
    </select>

    <div class="label">
        @if ($messages)
            <ul {{ $attributes->merge(['class' => 'text-sm text-red-400 dark:text-red-400 space-y-1']) }}>
                @foreach ((array) $messages as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>


