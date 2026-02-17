@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-4 border-sisc-gold text-sm font-bold leading-5 text-sisc-gold focus:outline-none focus:border-sisc-gold transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-4 border-transparent text-sm font-medium leading-5 text-purple-100 hover:text-white hover:border-sisc-gold focus:outline-none focus:text-white focus:border-sisc-gold transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

