@props(['disabled' => false, 'name', 'id', 'messages' =>[]])

<label class="w-full form-control">
    <div class="label">
        <span class="text-black label-text dark:text-gray-300"> {{ $name }} </span>
    </div>
    <input type="text" name="{{ strtolower($id) }}" id="{{ strtolower($id) }}" {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-black dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600
        focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full'. ($messages ? 'border-red-500 dark:border-red-500' : '')]) }}>
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
