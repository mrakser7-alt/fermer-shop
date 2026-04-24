<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-green-700 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors']) }}>
    {{ $slot }}
</button>
