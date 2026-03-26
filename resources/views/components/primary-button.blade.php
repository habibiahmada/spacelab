<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-900 dark:bg-slate-700 text-white rounded-lg hover:bg-slate-800 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-900 dark:focus:ring-slate-700 focus:ring-offset-2 transition font-medium']) }}>
    {{ $slot }}
</button>
