@php
    $bullets = [
        'Ein Tablet im Wartezimmer, eine Fachrichtung, vier Wochen.',
        'Fester Ansprechpartner — kein Ticket-System.',
        'Keine Telefonakquise, keine Newsletter — nur die Demo.',
    ];

    $pvsOptions = ['medatixx', 'CGM Albis', 'Turbomed', 'Medistar', 'RED', 't2med', 'Andere'];
@endphp

<section id="demo" class="marketing-cta" data-screen-label="06 Demo">
    <div style="display: flex; flex-direction: column; gap: 18px;">
        <span class="eyebrow">Pilot · 30 Tage</span>
        <h2 class="h1 section-head__title" style="margin: 0;">
            30 Minuten, in Ihrer Praxis.
        </h2>
        <p class="section-head__lede" style="max-width: 480px;">
            Wir kommen vorbei oder rufen an. Sie sehen Audania an einem echten
            Anamnese-Beispiel aus Ihrer Fachrichtung — und erhalten den AVV-Entwurf
            vorab, ohne dass Sie etwas unterschreiben.
        </p>

        <ul class="cta-list">
            @foreach ($bullets as $bullet)
                <li><span>{{ $bullet }}</span></li>
            @endforeach
        </ul>
    </div>

    <form class="cta-form" action="#" method="post" onsubmit="return false;">
        <label class="cta-field">
            <span class="caption">Praxis</span>
            <input type="text" name="praxis" class="field-input" placeholder="z. B. Praxis Dr. Reichert · Stuttgart">
        </label>

        <label class="cta-field">
            <span class="caption">Ansprechpartner:in · Praxisinhaber:in</span>
            <input type="text" name="contact" class="field-input" placeholder="Name">
        </label>

        <label class="cta-field">
            <span class="caption">E-Mail</span>
            <input type="email" name="email" class="field-input" placeholder="ihre-praxis@arzt.de">
        </label>

        <label class="cta-field">
            <span class="caption">Telefon · für Rückruf</span>
            <input type="tel" name="phone" class="field-input" placeholder="+49 711 …">
        </label>

        <div class="cta-field" data-cta-pvs>
            <span class="caption">Praxissoftware</span>
            <div class="cta-pvs">
                @foreach ($pvsOptions as $i => $option)
                    <button
                        type="button"
                        class="cta-pvs__pill {{ $i === 0 ? 'is-active' : '' }}"
                        data-cta-pvs-pill
                    >{{ $option }}</button>
                @endforeach
            </div>
            <input type="hidden" name="pvs" value="{{ $pvsOptions[0] }}" data-cta-pvs-input>
        </div>

        <button type="submit" class="btn-ink" style="margin-top: 6px; justify-content: center;">
            Termin vorschlagen
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </button>

        <div class="disclaimer" style="font-size: 12px;">
            <strong style="font-weight: 600; color: var(--color-ink);">
                Audania stellt keine Diagnosen und gibt keine Behandlungsempfehlungen.
            </strong>
            Wir schicken Ihnen den AVV-Entwurf vor dem Termin — verpflichtungsfrei.
        </div>
    </form>
</section>

<script>
    document.querySelectorAll('[data-cta-pvs]').forEach((group) => {
        const pills = group.querySelectorAll('[data-cta-pvs-pill]');
        const input = group.querySelector('[data-cta-pvs-input]');
        pills.forEach((pill) => {
            pill.addEventListener('click', () => {
                pills.forEach((p) => p.classList.remove('is-active'));
                pill.classList.add('is-active');
                if (input) input.value = pill.textContent.trim();
            });
        });
    });
</script>