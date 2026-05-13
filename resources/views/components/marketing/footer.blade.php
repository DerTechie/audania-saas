@php
    $home = route('marketing.home');
    $columns = [
        ['title' => 'Produkt',     'links' => ['Für Praxen', 'So funktioniert es', 'Anamnese-Bereiche', 'Preise · folgt', 'Demo vereinbaren']],
        ['title' => 'Vertrauen',   'links' => ['Datenschutz (DSGVO)', 'AVV abrufen', 'Dienstleister mit Datenzugriff', 'Sicherheit', 'Status']],
        ['title' => 'Unternehmen', 'links' => ['Über Audania', 'Build-in-Public', 'Presse', 'Kontakt', 'Impressum']],
    ];
    $hrefs = [
        'Für Praxen' => $home . '#top',
        'So funktioniert es' => $home . '#how',
        'Anamnese-Bereiche' => $home . '#anatomy',
        'Demo vereinbaren' => $home . '#demo',
        'Sicherheit' => $home . '#vertrauen',
        'Datenschutz (DSGVO)' => route('marketing.datenschutz'),
        'Impressum' => route('marketing.impressum'),
        'Über Audania' => route('marketing.journeys'),
        'Kontakt' => 'mailto:info@audania.de',
        'Preise · folgt' => null,
    ];
    $year = date('Y');
@endphp

<footer class="marketing-footer">
    <div class="marketing-footer__top">
        <div class="marketing-footer__brand">
            <span class="wordmark">Audania</span>
            <p class="marketing-footer__tagline">
                Strukturierte Anamnese, ehe Sie den Behandlungsraum betreten.
            </p>
            <div class="marketing-footer__meta">
                <span class="caption">Mike Esser Trading &amp; Consulting · Bonn</span>
                <span class="caption">Hosting: Hetzner Frankfurt (FRA1)</span>
                <span class="caption">EU-Sprachmodell · keine Trainingsnutzung</span>
            </div>
        </div>

        @foreach ($columns as $col)
            <div class="marketing-footer__col">
                <span class="eyebrow">{{ $col['title'] }}</span>
                <ul>
                    @foreach ($col['links'] as $link)
                        @php($href = array_key_exists($link, $hrefs) ? $hrefs[$link] : '#')
                        <li>
                            @if ($href === null)
                                <span class="is-disabled" aria-disabled="true">{{ $link }}</span>
                            @else
                                <a href="{{ $href }}">{{ $link }}</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <div class="marketing-footer__legal">
        <div class="marketing-footer__legal-inner">
            <span class="legal">© {{ $year }} Mike Esser Trading &amp; Consulting. Audania ist kein Medizinprodukt im Sinne der MDR.</span>
            <span class="legal">audania.de · audania.com · audania.ai</span>
        </div>
    </div>
</footer>
