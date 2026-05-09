@props([
    'title' => 'Audania — Wir hören zu, bevor der Arzt fragt.',
    'description' => 'Audania ist der KI-native Anamnese-Assistent für deutsche Arztpraxen — datenschutzkonform, gesprächsbasiert, und bewusst kein Medizinprodukt.',
])

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">

    <link rel="icon" href="{{ asset('images/audania-monogram.svg') }}" type="image/svg+xml">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="marketing-shell">
        {{ $slot }}
    </div>
</body>
</html>