@props([
    'title' => config('app.name'),
    'description' => 'Halaman default tanpa deskripsi'
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.meta.guest-head')
</head>
<body class="min-h-screen bg-white text-slate-900 dark:bg-slate-900 dark:text-slate-100 font-sans">

    <!-- NAV -->
    @include('partials.guest.navbar')

    <main class="pt-24">
        {{ $slot }}
    </main>
    
    <!-- FOOTER -->
    @include('partials.guest.footer')

</body>
</html>
