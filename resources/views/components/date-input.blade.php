@props(['disabled' => false])

<input type="date" @disabled($disabled)
    {{ $attributes->merge(['class' => 'block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 sm:text-sm']) }}>
