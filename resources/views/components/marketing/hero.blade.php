@php
    $pillars = [
        ['DSGVO-konform', 'Hosting in Frankfurt am Main'],
        ['PVS-neutral', 'medatixx · CGM Albis · RED · t2med'],
        ['Kein Medizinprodukt', 'MDR-by-design'],
    ];
@endphp

<section id="top" class="marketing-hero" data-screen-label="01 Hero">
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <span class="eyebrow">Für deutsche Arztpraxen · Stand Mai 2026</span>

        <h1 class="display marketing-hero__title">
            Wir hören zu, bevor der Arzt fragt.
        </h1>

        <p class="marketing-hero__lede">
            Audania ist der KI-native Anamnese-Assistent für deutsche Arztpraxen —
            gesprächsbasiert, datenschutzkonform, und bewusst kein Medizinprodukt.
            Die strukturierte Anamnese liegt im PVS, ehe der Patient ins Sprechzimmer gerufen wird.
        </p>

        <div class="marketing-hero__cta-row">
            <a href="#demo" class="btn-ink">
                Demo in Ihrer Praxis vereinbaren
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
            <a href="#how" class="btn-outline">So funktioniert es</a>
        </div>

        <div class="marketing-hero__pillars">
            @foreach ($pillars as [$title, $sub])
                <div style="display: flex; flex-direction: column; gap: 4px;">
                    <span class="marketing-hero__pillar-title">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--color-clay)" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ $title }}
                    </span>
                    <span class="marketing-hero__pillar-sub">{{ $sub }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="hero-demo">
        <div class="hero-demo__arc" aria-hidden="true"></div>

        <div class="hero-demo__tablet" data-slot-machine>
            <div class="hero-demo__chrome">
                <div class="hero-demo__chrome-left">
                    <span class="wordmark">Audania</span>
                    <span class="hero-demo__chrome-tag">Praxis Dr. Reichert</span>
                </div>
                <span class="mono hero-demo__chrome-id">SITZUNG · 4F-21</span>
            </div>

            <div class="hero-demo__body" data-slot-body aria-live="polite"></div>

            <div class="hero-demo__ribbon" data-slot-ribbon></div>
        </div>
    </div>
</section>