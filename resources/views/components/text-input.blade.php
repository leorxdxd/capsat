@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 bg-white text-gray-900 focus:border-sisc-purple focus:ring-sisc-purple rounded-none shadow-sm']) }}>

