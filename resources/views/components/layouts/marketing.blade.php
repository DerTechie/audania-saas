@props([
    'title' => 'Audania — Anamnese, ehe Sie den Patienten aufrufen.',
    'description' => 'Audania führt das Anamnese-Gespräch mit Ihren Patient:innen vor der Sprechstunde — auf Tablet oder Telefon, in zehn Sprachen. Der Befund liegt vor dem Gespräch in Ihrer Praxissoftware. Bewusst kein Medizinprodukt.',
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