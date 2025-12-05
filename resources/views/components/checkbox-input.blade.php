@props(['disabled' => false, 'checked' => false, 'value' => '1'])

<input type="checkbox" value="{{ $value }}" @checked($checked) @disabled($disabled)
    {{ $attributes->merge(['class' => 'rounded border-gray-300 dark:border-gray-600 text-gray-600 shadow-sm focus:ring-gray-500 dark:bg-gray-900']) }}>
