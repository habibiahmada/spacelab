<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>
    {{ ($title ?? config('app.name')) . (isset($description) ? ' | ' . $description : '') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link rel="manifest" href="/site.webmanifest">

<meta name="description" content="{{ $description ?? 'SpaceLab is an all-in-one academic schedule and facility management system designed to streamline school operations and enhance productivity.' }}">
<meta name="keywords" content="SpaceLab, Academic Schedule, Facility Management, School Management System, Education Software, Timetable Management, Resource Scheduling">
<meta name="author" content="SpaceLab Team">
<meta name="robots" content="index, follow">
<meta name="theme-color" content="#ffffff">

<!-- Open Graph / Facebook -->
<meta property="og:title" content="{{ $title ?? config('app.name') }}">
<meta property="og:description" content="{{ $description ?? 'SpaceLab is an all-in-one academic schedule and facility management system designed to streamline school operations and enhance productivity.' }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('og-image.png') }}">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title ?? config('app.name') }}">
<meta name="twitter:description" content="{{ $description ?? 'SpaceLab is an all-in-one academic schedule and facility management system designed to streamline school operations and enhance productivity.' }}">
<meta name="twitter:image" content="{{ asset('og-image.png') }}">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" /> 

<!-- Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Assets -->
@vite(['resources/css/app.css', 'resources/js/app.js'])