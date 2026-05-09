@php
    $facts = [
        [
            'label' => 'DSGVO',
            'title' => 'Hosting in Deutschland.',
            'body' => 'Hetzner Frankfurt als Default. STACKIT, IONOS, OVH FRA als zweite Quelle. Azure / AWS Frankfurt nur mit dokumentiertem EU-Residenz-Vertrag.',
        ],
        [
            'label' => 'Art. 9',
            'title' => 'EU-LLM, ohne Training.',
            'body' => 'Inferenz auf EU-Endpunkten — Mistral Large EU, Azure OpenAI Sweden, Aleph Alpha. Schriftliche No-Training-Klausel pro Anbieter.',
        ],
        [
            'label' => 'Art. 28',
            'title' => 'AVV liegt vor dem Pilot.',
            'body' => 'AVV-Vorlage, Sub-Auftragsverarbeiter-Liste, Datenfluss-Diagramme, Aufbewahrungs-Policy — alles bevor der erste echte Patient die Praxis betritt.',
        ],
        [
            'label' => 'MDR',
            'title' => 'Bewusst kein Medizinprodukt.',
            'body' => 'Kein Diagnose-Hinweis, keine Triage, keine Therapie-Empfehlung. Damit fallen wir nicht unter MDR Regel 11 — und liefern Features in Wochen statt MDR-Zyklen.',
        ],
    ];

    $pvs = ['medatixx', 'CGM Albis', 'Turbomed', 'Medistar', 'RED', 't2med'];
    $count = count($facts);
@endphp

<section id="datenschutz" class="marketing-compliance" data-screen-label="04 Datenschutz">
    <div class="section-head">
        <div>
            <span class="eyebrow">Datenschutz · MDR · AVV</span>
            <h2 class="h1 section-head__title section-head__title--smaller">
                Sichtbare Grenzen, nicht versteckte.
            </h2>
        </div>
        <p class="section-head__lede section-head__lede--narrow">
            Vier Posten, an denen wir lauter und konkreter sind als der Markt.
            Mittelstand-Praxen kaufen Datenresidenz, nicht Datenschutz-Theater —
            deshalb stehen die Verträge vor der ersten Sitzung.
        </p>
    </div>

    <div class="compliance-grid">
        @foreach ($facts as $i => $fact)
            <article @class([
                'compliance-card',
                'is-right-bordered' => $i % 2 === 0,
                'is-bottom-bordered' => $i >= $count - 2,
            ])>
                <span class="compliance-card__label">{{ $fact['label'] }}</span>
                <h3 class="compliance-card__title">{{ $fact['title'] }}</h3>
                <p class="compliance-card__body">{{ $fact['body'] }}</p>
            </article>
        @endforeach
    </div>

    <div class="pvs-strip">
        <div style="display: flex; flex-direction: column; gap: 4px;">
            <span class="pvs-strip__title">PVS-neutral. Ihre Praxissoftware bleibt.</span>
            <span class="pvs-strip__sub">GDT zum Start, FHIR R4 und HL7 v2 in Sequenz.</span>
        </div>
        <div class="pvs-strip__list">
            @foreach ($pvs as $name)
                <span class="pvs-pill">{{ $name }}</span>
            @endforeach
        </div>
    </div>
</section>