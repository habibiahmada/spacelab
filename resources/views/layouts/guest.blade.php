@props([
    'title' => config('app.name'),
    'description' => 'Halaman default tanpa deskripsi'
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.meta.guest-head')
</head>
<body class="min-h-screen bg-neskar-blue-50 text-slate-900 dark:bg-neskar-blue-950 dark:text-slate-100 font-sans">

    <!-- NAV -->
    @include('partials.guest.navbar')

    <main>
        {{ $slot }}
    </main>
    
    <!-- FOOTER -->
    @include('partials.guest.footer')

</body>
</html>
