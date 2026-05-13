@php
    $home = route('marketing.home');
    $links = [
        ['label' => 'Für Praxen', 'href' => $home . '#top'],
        ['label' => 'So funktioniert es', 'href' => $home . '#how'],
        ['label' => 'Wie Audania denkt', 'href' => route('marketing.journeys')],
        ['label' => 'Vertrauen', 'href' => $home . '#vertrauen'],
        ['label' => 'Preise · folgt', 'href' => null],
    ];
@endphp

<header class="marketing-header">
    <div class="marketing-header__inner">
        <a href="{{ $home }}" class="marketing-header__brand">
            <span class="wordmark">Audania</span>
        </a>

        <nav class="marketing-header__nav">
            @foreach ($links as $link)
                @if ($link['href'])
                    <a href="{{ $link['href'] }}">{{ $link['label'] }}</a>
                @else
                    <span class="is-disabled" aria-disabled="true">{{ $link['label'] }}</span>
                @endif
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