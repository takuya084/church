<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<link rel="icon" href="{{ asset('sda_favicon.ico') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('sda_favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('sda_favicon-16x16.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('sda_apple-touch-icon.png') }}">

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
