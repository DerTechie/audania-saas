@php
    $links = [
        ['label' => 'Für Praxen', 'href' => '#top'],
        ['label' => 'So funktioniert es', 'href' => '#how'],
        ['label' => 'Datenschutz', 'href' => '#datenschutz'],
        ['label' => 'Slot-Sets', 'href' => '#'],
        ['label' => 'Preise', 'href' => '#'],
    ];
@endphp

<header class="marketing-header">
    <div class="marketing-header__inner">
        <a href="#top" class="marketing-header__brand">
            <span class="wordmark">Audania</span>
        </a>

        <nav class="marketing-header__nav">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}">{{ $link['label'] }}</a>
            @endforeach
        </nav>

        <div class="marketing-header__actions">
            <a href="#" class="marketing-header__login">Anmelden</a>
            <a href="#demo" class="marketing-header__cta">
                Demo vereinbaren
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
        </div>
    </div>
</header>