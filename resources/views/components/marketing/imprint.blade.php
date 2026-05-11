@php
    $rows = [
        [
            'index' => 1,
            'label' => 'Diensteanbieter',
            'anchor' => 'anbieter',
            'heading' => 'Anbieter und Verantwortlicher',
        ],
        [
            'index' => 2,
            'label' => 'Kontakt',
            'anchor' => 'kontakt',
            'heading' => 'So erreichen Sie uns.',
        ],
        [
            'index' => 3,
            'label' => 'USt-IdNr.',
            'anchor' => 'ust',
            'heading' => 'Umsatzsteuer-Identifikations­nummer.',
        ],
        [
            'index' => 4,
            'label' => 'V.i.S.d.P.',
            'anchor' => 'redaktion',
            'heading' => 'Redaktionell verantwortlich.',
        ],
        [
            'index' => 5,
            'label' => 'VSBG',
            'anchor' => 'streitbeilegung',
            'heading' => 'Verbraucher­streit­beilegung & Universal­schlichtungs­stelle.',
        ],
        [
            'index' => 6,
            'label' => 'DSA · Art. 11–12',
            'anchor' => 'dsa',
            'heading' => 'Zentrale Kontaktstelle nach dem Digital Services Act.',
        ],
    ];
@endphp

<section class="imprint-hero">
    <div class="imprint-hero__inner">
        <div>
            <div class="imprint-hero__eyebrow-row">
                <span class="imprint-hero__rule" aria-hidden="true"></span>
                <span class="eyebrow">Rechtliches · § 5 TMG</span>
            </div>
            <h1 class="display imprint-hero__title">Impressum.</h1>
        </div>
        <div class="imprint-hero__aside">
            <p class="imprint-hero__lede">
                Angaben gemäß § 5 Telemediengesetz. Wer Verantwortung trägt,
                sollte adressierbar sein.
            </p>
            <div class="imprint-hero__meta">
                <span class="mono imprint-hero__meta-item">Stand: 11.&nbsp;Mai&nbsp;2026</span>
                <span class="imprint-hero__meta-dot" aria-hidden="true"></span>
                <span class="mono imprint-hero__meta-item">audania.de</span>
            </div>
        </div>
    </div>
</section>

<main class="imprint-body">
    <article id="anbieter" class="imprint-row">
        <div class="imprint-row__index">
            <span class="imprint-row__num">§ 01</span>
            <span class="imprint-row__label">Diensteanbieter</span>
        </div>
        <div class="imprint-row__content">
            <h2 class="imprint-row__heading">Anbieter und Verantwortlicher</h2>
            <address class="imprint-row__address">
                <strong>Mike Esser</strong><br>
                Mike Esser Trading &amp; Consulting<br>
                Klosterstraße 13<br>
                53123 Bonn<br>
                Deutschland
            </address>
        </div>
    </article>

    <article id="kontakt" class="imprint-row">
        <div class="imprint-row__index">
            <span class="imprint-row__num">§ 02</span>
            <span class="imprint-row__label">Kontakt</span>
        </div>
        <div class="imprint-row__content">
            <h2 class="imprint-row__heading">So erreichen Sie uns.</h2>
            <dl class="imprint-row__dl">
                <dt>Telefon</dt>
                <dd>
                    <a class="tnum" href="tel:+4916094461813">+49&nbsp;160&nbsp;94461813</a>
                </dd>
                <dt>E-Mail</dt>
                <dd>
                    <a href="mailto:info@audania.de">info@audania.de</a>
                </dd>
            </dl>
        </div>
    </article>

    <article id="ust" class="imprint-row">
        <div class="imprint-row__index">
            <span class="imprint-row__num">§ 03</span>
            <span class="imprint-row__label">USt-IdNr.</span>
        </div>
        <div class="imprint-row__content">
            <h2 class="imprint-row__heading">Umsatzsteuer-Identifikations&shy;nummer.</h2>
            <p class="imprint-row__paragraph">
                Umsatzsteuer-Identifikationsnummer gemäß § 27 a Umsatzsteuergesetz:
            </p>
            <p class="imprint-row__ust tnum">DE&nbsp;292&nbsp;918&nbsp;480</p>
        </div>
    </article>

    <article id="redaktion" class="imprint-row">
        <div class="imprint-row__index">
            <span class="imprint-row__num">§ 04</span>
            <span class="imprint-row__label">V.i.S.d.P.</span>
        </div>
        <div class="imprint-row__content">
            <h2 class="imprint-row__heading">Redaktionell verantwortlich.</h2>
            <address class="imprint-row__address">
                <strong>Mike Esser</strong><br>
                Klosterstraße 13<br>
                53123 Bonn
            </address>
            <p class="caption imprint-row__footnote">
                Verantwortlich nach § 18 Abs. 2 MStV für eigene journalistisch-redaktionelle Inhalte.
            </p>
        </div>
    </article>

    <article id="streitbeilegung" class="imprint-row">
        <div class="imprint-row__index">
            <span class="imprint-row__num">§ 05</span>
            <span class="imprint-row__label">VSBG</span>
        </div>
        <div class="imprint-row__content">
            <h2 class="imprint-row__heading">Verbraucher&shy;streit&shy;beilegung &amp; Universal&shy;schlichtungs&shy;stelle.</h2>
            <p class="imprint-row__paragraph">
                Wir sind <em class="imprint-row__emph">nicht bereit oder verpflichtet</em>,
                an Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle teilzunehmen.
            </p>
        </div>
    </article>

    <article id="dsa" class="imprint-row">
        <div class="imprint-row__index">
            <span class="imprint-row__num">§ 06</span>
            <span class="imprint-row__label">DSA · Art. 11–12</span>
        </div>
        <div class="imprint-row__content">
            <h2 class="imprint-row__heading">Zentrale Kontaktstelle nach dem Digital Services Act.</h2>
            <p class="imprint-row__paragraph imprint-row__paragraph--narrow">
                Verordnung (EU) 2022/2065. Unsere zentrale Kontaktstelle für Nutzer und Behörden
                nach Art. 11, 12 DSA erreichen Sie wie folgt:
            </p>
            <div class="imprint-dsa-card">
                <dl class="imprint-row__dl">
                    <dt>E-Mail</dt>
                    <dd>
                        <a href="mailto:info@dertechie.de">info@dertechie.de</a>
                    </dd>
                    <dt>Telefon</dt>
                    <dd>
                        <a class="tnum" href="tel:+4916094461813">+49&nbsp;160&nbsp;94461813</a>
                    </dd>
                    <dt>Sprachen</dt>
                    <dd class="imprint-dsa-card__langs">
                        <span class="imprint-dsa-card__lang">Deutsch</span>
                        <span class="imprint-dsa-card__lang">Englisch</span>
                    </dd>
                </dl>
            </div>
        </div>
    </article>

    <div class="imprint-body__rule" aria-hidden="true"></div>

    <div class="imprint-note">
        <div class="imprint-note__index">
            <span class="eyebrow">Hinweis</span>
        </div>
        <p class="caption imprint-note__body">
            Audania ist kein Medizinprodukt im Sinne der MDR (Verordnung (EU) 2017/745).
            Die Plattform liefert keine Diagnose, keine Triage und keine
            Therapie&shy;empfehlung — sie strukturiert ausschließlich die Anamnese
            vor dem Arzt&shy;gespräch.
        </p>
    </div>
</main>
