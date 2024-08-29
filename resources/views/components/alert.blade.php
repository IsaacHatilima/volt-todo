@props(['type', 'error'])

@if($error)
    <div role="alert" class="alert alert-{{$type}}">
        @if( $type == 'success' )
            <x-heroicon-c-shield-check class="w-10 h-10 text-white"/>
        @else
            <x-heroicon-c-exclamation-triangle class="w-10 h-10 text-white"/>
        @endif
        <span>{{ $type == 'success' ? 'Success' : 'Warning' }}: {{ $error }}</span>
    </div>
@endif
