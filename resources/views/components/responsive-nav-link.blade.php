@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-sisc-gold text-start text-base font-bold text-sisc-gold bg-purple-800 focus:outline-none focus:text-sisc-gold focus:bg-purple-800 focus:border-sisc-gold transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-purple-100 hover:text-white hover:bg-purple-800 hover:border-sisc-gold focus:outline-none focus:text-white focus:bg-purple-800 focus:border-sisc-gold transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

