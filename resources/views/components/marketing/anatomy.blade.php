@php
    $claims = [
        ['Wortgenau', 'Direkte Zitate der Patient:in landen unverändert im Befund — kein Marketing-Glätten.'],
        ['Sortiert', 'Pro Beschwerdebild liegt fest, welche Felder gefüllt werden. Sie lesen den Befund immer in derselben Reihenfolge.'],
        ['Beschreibend, nie wertend', 'Audania deutet nichts. Keine Verdachtsdiagnosen, keine Triage-Stufen, keine roten Warnsymbole.'],
    ];
@endphp

<section class="marketing-anatomy" data-screen-label="03 Worte und Befund">
    <div class="marketing-anatomy__inner">
        <div class="section-head">
            <div>
                <span class="eyebrow">Worte und Befund</span>
                <h2 class="h1 section-head__title section-head__title--smaller">
                    Die Worte der Patient:in. Sortiert für Ihr PVS.
                </h2>
            </div>
            <p class="section-head__lede section-head__lede--narrow">
                Audania hält fest, was die Patient:in gesagt hat — wortgenau,
                nicht paraphrasiert. Gleichzeitig sortiert sie die Antworten
                nach Anliegen, Verlauf, Charakter und Intensität, damit der Befund
                in Ihrem PVS lesbar ankommt.
            </p>
        </div>

        <div class="anatomy-grid">
            <div class="anatomy-card">
                <div class="anatomy-card__head">
                    <span class="anatomy-card__caption">Tablet im Wartezimmer</span>
                    <span class="anatomy-card__counter">Frage 2 von 12</span>
                </div>

                <p class="anatomy-card__question">Seit wann bestehen die Beschwerden?</p>
                <span class="anatomy-card__hint">Tage, Wochen, Monate</span>

                <div class="anatomy-card__answer">
                    Seit etwa drei Tagen, vor allem nach längerem Sitzen.
                </div>

                <div class="anatomy-spacer"></div>

                <div class="anatomy-card__footer">
                    <span class="ribbon-dot"></span>
                    Wortgenau gespeichert · in der Sprache der Patient:in
                </div>
            </div>

            <div class="anatomy-divider">
                <span class="anatomy-divider__label">Audania sortiert</span>
                <svg width="18" height="60" viewBox="0 0 18 60" fill="none" aria-hidden="true">
                    <line x1="9" y1="0" x2="9" y2="48" stroke="var(--color-clay-hairline)" stroke-width="1.5"/>
                    <path d="M3 44L9 52L15 44" stroke="var(--color-clay)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                </svg>
            </div>

            <div class="anatomy-card">
                <div class="anatomy-card__head">
                    <span class="anatomy-card__caption">Anamnese-Befund · in Ihrem PVS</span>
                    <span class="badge-neutral">medatixx</span>
                </div>

                <h3 class="anatomy-card__title">
                    Patient:in nicht identifiziert · Sitzung 4F-21
                </h3>

                <div class="anatomy-card__rows">
                    <div class="anatomy-card__label">Anliegen</div>
                    <div class="anatomy-card__value">Rückenschmerzen</div>

                    <div class="anatomy-card__label">Verlauf</div>
                    <div class="anatomy-card__value is-quote is-highlight">„Seit etwa drei Tagen, vor allem nach längerem Sitzen.“</div>

                    <div class="anatomy-card__label">Dauer</div>
                    <div class="anatomy-card__value tnum">3 Tage</div>

                    <div class="anatomy-card__label">Auslöser</div>
                    <div class="anatomy-card__value">längeres Sitzen</div>
                </div>

                <div class="anatomy-spacer"></div>

                <div class="anatomy-card__footer-pill">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--color-note-ink)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Übergeben an Ihr PVS · vor dem Aufruf ins Sprechzimmer
                </div>
            </div>
        </div>

        <div class="anatomy-claims">
            @foreach ($claims as [$title, $body])
                <div class="anatomy-claim">
                    <span class="anatomy-claim__title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--color-clay)" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ $title }}
                    </span>
                    <p class="anatomy-claim__body">{{ $body }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>