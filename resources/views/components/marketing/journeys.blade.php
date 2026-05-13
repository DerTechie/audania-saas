<section class="tj-intro" id="top">
    <div>
        <span class="eyebrow">Architektur · Wie Audania denkt</span>
        <h1 class="tj-intro__title">Wie Audania denkt.</h1>
    </div>
    <p class="tj-intro__lede">
        Jede Sitzung läuft in drei Spuren ab: was die Patient:in schreibt,
        was das Modell daraus an strukturierten Slots zurückgibt, und was
        die deterministische Policy als Nächstes macht. Drei Beispiele,
        dieselbe Architektur — auf Deutsch, auf Türkisch, mit Mutter und Kind.
    </p>
</section>

<section class="tj-shell" data-three-journeys>
    <div class="tj-tabs" data-tj-tabs></div>
    <div class="tj-stage" data-tj-stage></div>
    <div data-tj-caption></div>
    <div data-tj-transport></div>
</section>

<section class="tj-pillars">
    <div class="tj-pillars__head">
        <div>
            <span class="eyebrow">Verantwortlichkeiten</span>
            <h2 class="tj-pillars__title">Was das Modell tut — und was nicht.</h2>
        </div>
        <p class="tj-pillars__lede">
            Patient:innen <em>erleben</em> ein flüssiges, mehrsprachiges Gespräch.
            Intern macht das Modell ausschließlich den Schritt „unstrukturierter Text → strukturierte Daten“.
            Genau deshalb lässt es sich evaluieren, auditieren — und es bleibt strukturell außerhalb der MDR.
        </p>
    </div>

    @php
        $does = [
            'Liest Patient:innen-Eingaben in jeder unterstützten Sprache.',
            'Gibt eine strukturierte Datenmenge gegen ein festes Schema zurück.',
            'Liefert zu jedem Wert ein Belegzitat — auditierbar.',
            'Wandelt formlosen Text in Zeitleisten, Mengen, Listen um.',
        ];
        $doesnt = [
            'Wählt nicht die nächste Frage. Das macht die Policy.',
            'Schreibt keine Antwort an die Patient:in. Das übernimmt eine feste Vorlagen-Sammlung.',
            'Definiert keine Fragen. Die liegen in der Versions-Kontrolle.',
            'Diagnostiziert nicht, triagiert nicht, empfiehlt keine Handlung — diese Funktion existiert nicht.',
        ];
    @endphp

    <div class="tj-pillars__grid">
        <div class="tj-pillar is-positive">
            <span class="tj-pillar__tag">JA</span>
            <h3 class="tj-pillar__title">Was das Modell tut</h3>
            <ul class="tj-pillar__list">
                @foreach ($does as $item)
                    <li>
                        <span class="tj-pillar__bullet">
                            <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <span>{{ $item }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="tj-pillar">
            <span class="tj-pillar__tag">NEIN</span>
            <h3 class="tj-pillar__title">Was das Modell nicht tut</h3>
            <ul class="tj-pillar__list">
                @foreach ($doesnt as $item)
                    <li>
                        <span class="tj-pillar__bullet">
                            <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="var(--color-mute)" stroke-width="3" stroke-linecap="round"><line x1="6" y1="12" x2="18" y2="12"/></svg>
                        </span>
                        <span>{{ $item }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>