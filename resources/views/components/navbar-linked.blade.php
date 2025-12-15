@props(['route', 'label', 'active' => null, 'bold' => false])

@php
    $isActive = $active ? request()->is($active) : request()->routeIs($route);
    $classes = 'font-T4-Regular text-decoration-none ' . 
               (($isActive || $bold) ? 'text-dark fw-bold' : '');
@endphp

<a href="{{ Route::has($route) ? route($route) : '#' }}" class="{{ $classes }}">
    {{ $label }}
</a>