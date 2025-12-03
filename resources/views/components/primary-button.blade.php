<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full inline-flex justify-center items-center rounded-xl bg-indigo-600 text-white font-medium py-2.5 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-400 focus:ring-opacity-30 transition']) }}>
    {{ $slot }}
</button>
