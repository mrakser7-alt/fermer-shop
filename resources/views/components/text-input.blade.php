@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border border-gray-200 focus:border-green-400 focus:ring-green-400 rounded-xl shadow-none text-sm w-full px-4 py-2.5 transition-colors']) }}>
