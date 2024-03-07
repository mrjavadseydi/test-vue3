<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Settings</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    @vite(\Nwidart\Modules\Module::getAssets())
    <link rel="stylesheet" href="https://classless.de/classless.css">
</head>

<body id="settings" class="font-sans antialiased">
<div>

    <settings/>
</div>
</body>
</html>
