<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-sisc-purple border border-transparent rounded font-bold text-xs text-white uppercase tracking-widest hover:bg-violet-900 active:bg-violet-950 focus:outline-none focus:ring-2 focus:ring-sisc-gold focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg hover:-translate-y-0.5']) }}>
    {{ $slot }}
</button>

