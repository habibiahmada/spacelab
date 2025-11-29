<div class="w-8 h-8 rounded-md bg-gradient-to-br from-white to-accent flex items-center justify-center dark:from-slate-800 dark:to-accent">

    <!-- Logo saat LIGHT -->
    <img 
        src="{{ asset('assets/images/logo/spacelab-dark-logo.svg') }}" 
        alt="Logo Light" 
        class="w-6 h-6 dark:hidden"
    />

    <!-- Logo saat DARK -->
    <img 
        src="{{ asset('assets/images/logo/spacelab-white-logo.svg') }}" 
        alt="Logo Dark" 
        class="w-6 h-6 hidden dark:block"
    />

</div>
