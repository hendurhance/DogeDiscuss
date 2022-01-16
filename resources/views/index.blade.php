<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- meta --}}
    <meta name="description" content="DogeDiscuss is a platform for thousands of communities to share opinions regarding trending crypto coin.">
    <meta property="og:title" content="DogeDiscuss" />
    <meta property="og:description" content="DogeDiscuss is a platform for thousands of communities to share opinions regarding trending crypto coin." />
    <meta property="og:image" content="{{ asset('img/logo-green.svg') }}" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@DogeDiscuss" />
    <meta name="twitter:creator" content="@DogeDiscuss" />
    <meta name="twitter:title" content="DogeDiscuss" />
    <meta name="twitter:description" content="DogeDiscuss is a platform for thousands of communities to share opinions regarding trending crypto coin." />
    <meta name="twitter:image" content="{{ asset('img/logo-green.svg') }}" />
    {{-- favicon --}}
    {{-- more meta --}}
    <link rel="stylesheet" href="/css/app.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <title>DogeDiscuss</title>

</head>

<body>

    <div id="app">
        <v-app>
            <app-home></app-home>
        </v-app>
    </div>

    <script src="/js/app.js"></script>
</body>

</html>