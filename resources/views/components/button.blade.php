@props([
    'color' => 'primary', // pass in
    'size' => 'md', // pass in
    'tag' => 'button',
    'href' => '/',
    'submit' => false, // pass in
    'rounded' => 'md' // pass in
])

@php
    $sizeClasses = match ($size) {
        'sm' => 'px-2.5 py-1.5 text-xs font-medium rounded-' . $rounded,
        'md' => 'px-4 py-2 text-sm font-medium rounded-' . $rounded,
        'lg' => 'px-5 py-3  text-sm font-medium rounded-' . $rounded,
        'xl' => 'px-6 py-3.5 text-base font-medium rounded-' . $rounded,
        '2xl' => 'px-7 py-4 text-base font-medium rounded-' . $rounded
    };
@endphp

@php
    $typeClasses = match ($color) {
        'primary' => 'bg-gray-800 dark:bg-gray-900 text-white dark:text-white hover:bg-gray-900 dark:focus:ring-offset-gray-700 dark:focus:ring-gray-100 dark:hover:bg-gray-700 dark:hover:text-white focus:ring-2 focus:ring-gray-900 focus:ring-offset-2',
        'danger' => 'bg-red-600 text-white hover:bg-red-600/90 focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-900 focus:bg-red-700/90 focus:ring-red-700',
        'success' => 'bg-green-600 text-white hover:bg-green-600/90 focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-900 focus:bg-green-700/90 focus:ring-green-700',
        'warning' => 'bg-amber-500 text-white hover:bg-amber-500/90 focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-900 focus:bg-amber-600/90 focus:ring-amber-600',
        'info' => 'bg-blue-600 text-white hover:bg-blue-600/90 focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-900 focus:bg-blue-700/90 focus:ring-blue-700',
    };
@endphp

@php
    switch ($tag ?? 'button') {
        case 'button':
            $tagAttr = ($submit) ? 'button type="submit"' : 'button type="button"';
            $tagClose = 'button';
            break;
        case 'a':
            $link = $href ?? '';
            $tagAttr = 'a  href="' . $link . '"';
            $tagClose = 'a';
            break;
        default:
            $tagAttr = 'button type="button"';
            $tagClose = 'button';
            break;
    }
@endphp

<{!! $tagAttr !!} {!! $attributes->merge([
    'class' => 'cursor-pointer inline-flex items-center p-4 justify-center disabled:opacity-50 font-semibold focus:outline-none shadow-lg duration-300 ease-in-out hover:scale-105 '. $typeClasses.$sizeClasses,
    'wire:loading.attr' => 'disabled', // Disable the button while loading
    'wire:target' => $attributes->wire('click')->value(), // Target the event that triggers loading
]) !!}>
<span wire:loading wire:target="{{ $attributes->wire('click')->value() }}" class="mr-2">
        <!-- Spinner SVG or any spinner icon you prefer -->
        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
    </span>
{{ $slot }}
</{{ $tagClose }}>
