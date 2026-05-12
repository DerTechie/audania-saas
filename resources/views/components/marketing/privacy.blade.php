@php
    $chapters = [
        ['num' => 1, 'label' => 'Auf einen Blick',       'anchor' => 'ueberblick'],
        ['num' => 2, 'label' => 'Hosting & CDN',         'anchor' => 'hosting'],
        ['num' => 3, 'label' => 'Pflichtinformationen',  'anchor' => 'pflicht'],
        ['num' => 4, 'label' => 'Datenerfassung',        'anchor' => 'datenerfassung'],
        ['num' => 5, 'label' => 'Newsletter',            'anchor' => 'newsletter'],
        ['num' => 6, 'label' => 'eCommerce & Zahlung',   'anchor' => 'ecommerce'],
    ];

    $quickLinks = [
        ['label' => 'Verantwortliche Stelle',     'anchor' => 'verantwortlich'],
        ['label' => 'Widerspruchsrecht (Art. 21)', 'anchor' => 'widerspruch'],
        ['label' => 'Beschwerderecht',            'anchor' => 'beschwerde'],
        ['label' => 'Kontaktformular',            'anchor' => 'kontaktformular'],
    ];

    $legalBasis = [
        ['Art. 6 Abs. 1 lit. a',  'Einwilligung'],
        ['Art. 6 Abs. 1 lit. b',  'Vertrag / vorvertragliche Maßnahmen'],
        ['Art. 6 Abs. 1 lit. c',  'Rechtliche Verpflichtung'],
        ['Art. 6 Abs. 1 lit. f',  'Berechtigtes Interesse'],
        ['Art. 9 Abs. 2 lit. a',  'Einwilligung – besondere Datenkategorien'],
        ['Art. 49 Abs. 1 lit. a', 'Ausdrückliche Einwilligung – Drittstaaten'],
        ['§ 25 Abs. 1 TDDDG',     'Cookies / Endgerätzugriff'],
    ];

    $cookieTypes = [
        ['First-Party', 'Von uns gesetzt, technisch notwendig.'],
        ['Third-Party', 'Eingebundene Dienste Dritter (z. B. Zahlungs­dienstleister).'],
        ['Session',     'Automatisch gelöscht am Sitzungsende.'],
        ['Permanent',   'Bleiben gespeichert bis zur manuellen Löschung.'],
    ];

    $logFields = [
        'Browsertyp und Browserversion',
        'Verwendetes Betriebssystem',
        'Referrer URL',
        'Hostname des zugreifenden Rechners',
        'Uhrzeit der Serveranfrage',
        'IP-Adresse',
    ];
@endphp

<section class="privacy-hero">
    <div class="privacy-hero__inner">
        <div>
            <div class="privacy-hero__eyebrow-row">
                <span class="privacy-hero__rule" aria-hidden="true"></span>
                <span class="eyebrow">Rechtliches · DSGVO · TDDDG</span>
            </div>
            <h1 class="display privacy-hero__title">Datenschutz&shy;erklärung.</h1>
        </div>
        <div class="privacy-hero__aside">
            <p class="privacy-hero__lede">
                Welche Daten wir erheben, warum, auf welcher Rechts&shy;grundlage —
                und welche Rechte Sie jederzeit ausüben können.
            </p>
            <div class="privacy-hero__meta">
                <span class="mono privacy-hero__meta-item">Stand: 11.&nbsp;Mai&nbsp;2026</span>
                <span class="privacy-hero__meta-dot" aria-hidden="true"></span>
                <span class="mono privacy-hero__meta-item">audania.de</span>
                <span class="privacy-hero__meta-dot" aria-hidden="true"></span>
                <span class="mono privacy-hero__meta-item">Lesedauer ~ 14&nbsp;min</span>
            </div>
        </div>
    </div>
</section>

<main class="privacy-body">
    <aside class="privacy-toc">
        <span class="eyebrow privacy-toc__heading">Inhalt</span>
        <ol class="privacy-toc__list">
            @foreach ($chapters as $c)
                <li class="privacy-toc__item">
                    <span class="privacy-toc__num tnum">{{ str_pad((string) $c['num'], 2, '0', STR_PAD_LEFT) }}</span>
                    <a class="privacy-toc__link" href="#{{ $c['anchor'] }}">{{ $c['label'] }}</a>
                </li>
            @endforeach
        </ol>
        <div class="privacy-toc__quick">
            <span class="eyebrow privacy-toc__heading">Schnellzugriff</span>
            <ul class="privacy-toc__quick-list">
                <li><a class="privacy-toc__quick-link" href="#verantwortlich">Verantwortliche Stelle</a></li>
                <li><a class="privacy-toc__quick-link" href="#widerspruch">Widerspruchsrecht (Art.&nbsp;21)</a></li>
                <li><a class="privacy-toc__quick-link" href="#beschwerde">Beschwerderecht</a></li>
                <li><a class="privacy-toc__quick-link" href="#kontaktformular">Kontaktformular</a></li>
            </ul>
        </div>
    </aside>

    <div class="privacy-content">
        {{-- ----------------- Chapter 1 ----------------- --}}
        <section class="privacy-chapter" id="ueberblick">
            <div class="privacy-chapter__head">
                <span class="privacy-chapter__num">KAPITEL&nbsp;01</span>
                <span class="privacy-chapter__rule" aria-hidden="true"></span>
            </div>
            <h2 class="privacy-chapter__title">Datenschutz auf einen Blick</h2>
            <p class="privacy-chapter__intro">
                Die folgenden Hinweise geben einen einfachen Überblick darüber, was mit Ihren
                personen&shy;bezogenen Daten passiert, wenn Sie diese Website besuchen.
                Ausführliche Informationen finden Sie in den weiteren Kapiteln.
            </p>

            <div class="privacy-chapter__subs">
                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">1.1</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Allgemeine Hinweise</h3>
                        <div class="privacy-prose">
                            <p>Personen&shy;bezogene Daten sind alle Daten, mit denen Sie persönlich identifiziert werden können. Ausführliche Informationen zum Thema Datenschutz entnehmen Sie unserer unter diesem Text aufgeführten Datenschutz&shy;erklärung.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">1.2</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Datenerfassung auf dieser Website</h3>

                        <div class="privacy-q">
                            <h4 class="privacy-q__q">Wer ist verantwortlich für die Datenerfassung?</h4>
                            <div class="privacy-prose privacy-prose--sm">
                                <p>Die Datenverarbeitung auf dieser Website erfolgt durch den Websitebetreiber. Dessen Kontaktdaten können Sie dem Abschnitt <a href="#verantwortlich" class="link-clay">„Hinweis zur verantwortlichen Stelle"</a> in dieser Datenschutz&shy;erklärung entnehmen.</p>
                            </div>
                        </div>

                        <div class="privacy-q">
                            <h4 class="privacy-q__q">Wie erfassen wir Ihre Daten?</h4>
                            <div class="privacy-prose privacy-prose--sm">
                                <p>Ihre Daten werden zum einen dadurch erhoben, dass Sie uns diese mitteilen — etwa Daten, die Sie in ein Kontaktformular eingeben.</p>
                                <p>Andere Daten werden automatisch oder nach Ihrer Einwilligung beim Besuch der Website durch unsere IT-Systeme erfasst. Das sind vor allem technische Daten (z.&nbsp;B. Internet&shy;browser, Betriebs&shy;system oder Uhrzeit des Seiten&shy;aufrufs).</p>
                            </div>
                        </div>

                        <div class="privacy-q">
                            <h4 class="privacy-q__q">Wofür nutzen wir Ihre Daten?</h4>
                            <div class="privacy-prose privacy-prose--sm">
                                <p>Ein Teil der Daten wird erhoben, um eine fehlerfreie Bereitstellung der Website zu gewährleisten. Andere Daten können zur Analyse Ihres Nutzer&shy;verhaltens verwendet werden. Sofern über die Website Verträge geschlossen oder angebahnt werden, werden die übermittelten Daten auch für Vertrags&shy;angebote, Bestellungen oder sonstige Auftrags&shy;anfragen verarbeitet.</p>
                            </div>
                        </div>

                        <div class="privacy-q">
                            <h4 class="privacy-q__q">Welche Rechte haben Sie bezüglich Ihrer Daten?</h4>
                            <div class="privacy-prose privacy-prose--sm">
                                <p>Sie haben jederzeit das Recht, unentgeltlich Auskunft über Herkunft, Empfänger und Zweck Ihrer gespeicherten personen&shy;bezogenen Daten zu erhalten. Sie haben außerdem ein Recht auf Berichtigung oder Löschung. Eine erteilte Einwilligung können Sie jederzeit für die Zukunft widerrufen. Unter bestimmten Umständen können Sie die Einschränkung der Verarbeitung verlangen. Des Weiteren steht Ihnen ein Beschwerderecht bei der zuständigen Aufsichts&shy;behörde zu.</p>
                                <p>Hierzu sowie zu weiteren Fragen können Sie sich jederzeit an uns wenden.</p>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        {{-- ----------------- Chapter 2 ----------------- --}}
        <section class="privacy-chapter" id="hosting">
            <div class="privacy-chapter__head">
                <span class="privacy-chapter__num">KAPITEL&nbsp;02</span>
                <span class="privacy-chapter__rule" aria-hidden="true"></span>
            </div>
            <h2 class="privacy-chapter__title">Hosting und Content Delivery Networks</h2>
            <p class="privacy-chapter__intro">Wir hosten die Inhalte unserer Website bei folgenden Anbietern.</p>

            <div class="privacy-chapter__subs">
                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">2.1 · AWS</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Amazon Web Services (AWS)</h3>
                        <div class="privacy-prose">
                            <p>Anbieter ist die Amazon Web Services EMEA SARL, 38 Avenue John F. Kennedy, 1855 Luxemburg (nachfolgend AWS).</p>
                            <p>Wenn Sie unsere Website besuchen, werden Ihre personen&shy;bezogenen Daten auf den Servern von AWS verarbeitet. Hierbei können auch personen&shy;bezogene Daten an das Mutter&shy;unternehmen von AWS in die USA übermittelt werden. Die Daten&shy;übertragung in die USA wird auf die EU-Standard&shy;vertrags&shy;klauseln gestützt.</p>
                        </div>

                        <p class="privacy-link-row">
                            <span class="privacy-link-row__label">AVV / GDPR Addendum</span>
                            <a class="privacy-link-row__href" href="https://aws.amazon.com/de/blogs/security/aws-gdpr-data-processing-addendum/" target="_blank" rel="noopener noreferrer">https://aws.amazon.com/de/blogs/security/aws-gdpr-data-processing-addendum/</a>
                        </p>
                        <p class="privacy-link-row">
                            <span class="privacy-link-row__label">Datenschutzerklärung AWS</span>
                            <a class="privacy-link-row__href" href="https://aws.amazon.com/de/privacy/?nc1=f_pr" target="_blank" rel="noopener noreferrer">https://aws.amazon.com/de/privacy/?nc1=f_pr</a>
                        </p>

                        <div class="privacy-prose">
                            <p>Die Verwendung von AWS erfolgt auf Grundlage von Art.&nbsp;6 Abs.&nbsp;1 lit.&nbsp;f DSGVO. Wir haben ein berechtigtes Interesse an einer möglichst zuverlässigen Darstellung unserer Website. Sofern eine entsprechende Einwilligung abgefragt wurde, erfolgt die Verarbeitung ausschließlich auf Grundlage von Art.&nbsp;6 Abs.&nbsp;1 lit.&nbsp;a DSGVO und §&nbsp;25 Abs.&nbsp;1 TDDDG. Die Einwilligung ist jederzeit widerrufbar.</p>
                        </div>

                        <div class="privacy-dpf">
                            <div class="privacy-dpf__badge">DPF</div>
                            <div class="privacy-dpf__body">
                                <strong>EU-US Data Privacy Framework.</strong>
                                Das Unternehmen ist nach dem DPF zertifiziert — einem Übereinkommen zwischen der EU und den USA zur Einhaltung europäischer Datenschutz&shy;standards. Teilnehmer-Nr.
                                <a class="mono" href="https://www.dataprivacyframework.gov/participant/5776" target="_blank" rel="noopener noreferrer">5776</a>.
                            </div>
                        </div>

                        <h4 class="privacy-subheading">Auftragsverarbeitung</h4>
                        <div class="privacy-prose">
                            <p>Wir haben einen Vertrag über Auftrags&shy;verarbeitung (AVV) zur Nutzung des oben genannten Dienstes geschlossen. Hierbei handelt es sich um einen datenschutz&shy;rechtlich vorgeschriebenen Vertrag, der gewährleistet, dass dieser die personen&shy;bezogenen Daten unserer Website&shy;besucher nur nach unseren Weisungen und unter Einhaltung der DSGVO verarbeitet.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">2.2 · Cloudflare</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Cloudflare</h3>
                        <div class="privacy-prose">
                            <p>Wir nutzen den Service „Cloudflare". Anbieter ist die Cloudflare Inc., 101 Townsend St., San Francisco, CA 94107, USA (im Folgenden „Cloudflare").</p>
                            <p>Cloudflare bietet ein weltweit verteiltes Content Delivery Network mit DNS an. Dabei wird technisch der Informations&shy;transfer zwischen Ihrem Browser und unserer Website über das Netzwerk von Cloudflare geleitet. Das versetzt Cloudflare in die Lage, den Datenverkehr zwischen Ihrem Browser und unserer Website zu analysieren und als Filter zwischen unseren Servern und potenziell bösartigem Datenverkehr aus dem Internet zu dienen. Hierbei kann Cloudflare auch Cookies oder sonstige Technologien zur Wiedererkennung von Internet&shy;nutzern einsetzen, die jedoch allein zum hier beschriebenen Zweck verwendet werden.</p>
                            <p>Der Einsatz von Cloudflare beruht auf unserem berechtigten Interesse an einer möglichst fehlerfreien und sicheren Bereitstellung unseres Webangebotes (Art.&nbsp;6 Abs.&nbsp;1 lit.&nbsp;f DSGVO).</p>
                            <p>Die Daten&shy;übertragung in die USA wird auf die Standard&shy;vertrags&shy;klauseln der EU-Kommission gestützt.</p>
                        </div>

                        <p class="privacy-link-row">
                            <span class="privacy-link-row__label">Privacy Policy Cloudflare</span>
                            <a class="privacy-link-row__href" href="https://www.cloudflare.com/privacypolicy/" target="_blank" rel="noopener noreferrer">https://www.cloudflare.com/privacypolicy/</a>
                        </p>

                        <div class="privacy-dpf">
                            <div class="privacy-dpf__badge">DPF</div>
                            <div class="privacy-dpf__body">
                                <strong>EU-US Data Privacy Framework.</strong>
                                Das Unternehmen ist nach dem DPF zertifiziert — einem Übereinkommen zwischen der EU und den USA zur Einhaltung europäischer Datenschutz&shy;standards. Teilnehmer-Nr.
                                <a class="mono" href="https://www.dataprivacyframework.gov/participant/5666" target="_blank" rel="noopener noreferrer">5666</a>.
                            </div>
                        </div>

                        <h4 class="privacy-subheading">Auftragsverarbeitung</h4>
                        <div class="privacy-prose">
                            <p>Wir haben einen Vertrag über Auftrags&shy;verarbeitung (AVV) zur Nutzung des oben genannten Dienstes geschlossen.</p>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        {{-- ----------------- Chapter 3 ----------------- --}}
        <section class="privacy-chapter" id="pflicht">
            <div class="privacy-chapter__head">
                <span class="privacy-chapter__num">KAPITEL&nbsp;03</span>
                <span class="privacy-chapter__rule" aria-hidden="true"></span>
            </div>
            <h2 class="privacy-chapter__title">Allgemeine Hinweise und Pflichtinformationen</h2>

            <div class="privacy-chapter__subs">
                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">3.1</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Datenschutz</h3>
                        <div class="privacy-prose">
                            <p>Die Betreiber dieser Seiten nehmen den Schutz Ihrer persönlichen Daten sehr ernst. Wir behandeln Ihre personen&shy;bezogenen Daten vertraulich und entsprechend den gesetzlichen Datenschutz&shy;vorschriften sowie dieser Datenschutz&shy;erklärung.</p>
                            <p>Wenn Sie diese Website benutzen, werden verschiedene personen&shy;bezogene Daten erhoben. Personen&shy;bezogene Daten sind Daten, mit denen Sie persönlich identifiziert werden können. Die vorliegende Datenschutz&shy;erklärung erläutert, welche Daten wir erheben und wofür wir sie nutzen. Sie erläutert auch, wie und zu welchem Zweck das geschieht.</p>
                            <p>Wir weisen darauf hin, dass die Daten&shy;übertragung im Internet (z.&nbsp;B. bei der Kommunikation per E-Mail) Sicherheits&shy;lücken aufweisen kann. Ein lückenloser Schutz der Daten vor dem Zugriff durch Dritte ist nicht möglich.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub" id="verantwortlich">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">3.2 · § 5 TMG</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Hinweis zur verantwortlichen Stelle</h3>
                        <div class="privacy-prose">
                            <p>Die verantwortliche Stelle für die Datenverarbeitung auf dieser Website ist:</p>
                        </div>
                        <div class="privacy-responsible-card">
                            <address class="privacy-responsible-card__address">
                                <strong>Mike Esser Trading &amp; Consulting</strong><br>
                                Mike Esser<br>
                                Klosterstraße 13<br>
                                53123 Bonn
                            </address>
                            <dl class="privacy-responsible-card__dl">
                                <dt>Telefon</dt>
                                <dd><a class="tnum" href="tel:+4916094461813">+49&nbsp;160&nbsp;94461813</a></dd>
                                <dt>E-Mail</dt>
                                <dd><a href="mailto:info@audania.de">info@audania.de</a></dd>
                            </dl>
                        </div>
                        <div class="privacy-prose">
                            <p>Verantwortliche Stelle ist die natürliche oder juristische Person, die allein oder gemeinsam mit anderen über die Zwecke und Mittel der Verarbeitung von personen&shy;bezogenen Daten entscheidet.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">3.3</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Speicherdauer</h3>
                        <div class="privacy-prose">
                            <p>Soweit innerhalb dieser Datenschutz&shy;erklärung keine speziellere Speicherdauer genannt wurde, verbleiben Ihre personen&shy;bezogenen Daten bei uns, bis der Zweck für die Datenverarbeitung entfällt. Wenn Sie ein berechtigtes Lösch&shy;ersuchen geltend machen oder eine Einwilligung zur Datenverarbeitung widerrufen, werden Ihre Daten gelöscht, sofern wir keine anderen rechtlich zulässigen Gründe für die Speicherung haben (z.&nbsp;B. steuer- oder handels&shy;rechtliche Aufbewahrungs&shy;fristen).</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">3.4</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Allgemeine Hinweise zu den Rechtsgrundlagen</h3>
                        <div class="privacy-prose">
                            <p>Sofern Sie in die Datenverarbeitung eingewilligt haben, verarbeiten wir Ihre personen&shy;bezogenen Daten auf Grundlage von Art.&nbsp;6 Abs.&nbsp;1 lit.&nbsp;a DSGVO bzw. Art.&nbsp;9 Abs.&nbsp;2 lit.&nbsp;a DSGVO. Bei ausdrücklicher Einwilligung in die Übertragung in Drittstaaten zusätzlich Art.&nbsp;49 Abs.&nbsp;1 lit.&nbsp;a DSGVO. Bei Cookies bzw. Zugriff auf Endgerät&shy;informationen zusätzlich §&nbsp;25 Abs.&nbsp;1 TDDDG.</p>
                        </div>
                        <dl class="privacy-legal-basis">
                            @foreach ($legalBasis as [$art, $desc])
                                <div class="privacy-legal-basis__row">
                                    <dt class="mono">{{ $art }}</dt>
                                    <dd>{{ $desc }}</dd>
                                </div>
                            @endforeach
                        </dl>
                        <div class="privacy-prose">
                            <p>Über die jeweils im Einzelfall einschlägigen Rechtsgrundlagen wird in den folgenden Abschnitten dieser Datenschutz&shy;erklärung informiert.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">3.5</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Empfänger von personenbezogenen Daten</h3>
                        <div class="privacy-prose">
                            <p>Im Rahmen unserer Geschäfts&shy;tätigkeit arbeiten wir mit verschiedenen externen Stellen zusammen. Dabei ist teilweise auch eine Übermittlung von personen&shy;bezogenen Daten an diese externen Stellen erforderlich. Wir geben personen&shy;bezogene Daten nur dann weiter, wenn dies im Rahmen einer Vertragserfüllung erforderlich ist, wenn wir gesetzlich hierzu verpflichtet sind, wenn wir ein berechtigtes Interesse nach Art.&nbsp;6 Abs.&nbsp;1 lit.&nbsp;f DSGVO haben oder wenn eine sonstige Rechts&shy;grundlage die Daten&shy;weitergabe erlaubt. Beim Einsatz von Auftrags&shy;verarbeitern geben wir personen&shy;bezogene Daten nur auf Grundlage eines gültigen AVV weiter.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">3.6</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Widerruf Ihrer Einwilligung zur Datenverarbeitung</h3>
                        <div class="privacy-prose">
                            <p>Viele Datenverarbeitungs&shy;vorgänge sind nur mit Ihrer ausdrücklichen Einwilligung möglich. Sie können eine bereits erteilte Einwilligung jederzeit widerrufen. Die Rechtmäßigkeit der bis zum Widerruf erfolgten Datenverarbeitung bleibt vom Widerruf unberührt.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub" id="widerspruch">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">3.7 · Art. 21 DSGVO</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Widerspruchsrecht in besonderen Fällen sowie gegen Direktwerbung</h3>
                        <div class="privacy-callout">
                            <p><strong>Wenn die Datenverarbeitung auf Grundlage von Art.&nbsp;6 Abs.&nbsp;1 lit.&nbsp;e oder f DSGVO erfolgt</strong>, haben Sie jederzeit das Recht, aus Gründen, die sich aus Ihrer besonderen Situation ergeben, gegen die Verarbeitung Ihrer personen&shy;bezogenen Daten Widerspruch einzulegen; dies gilt auch für ein auf diese Bestimmungen gestütztes Profiling. Wenn Sie Widerspruch einlegen, werden wir Ihre betroffenen personen&shy;bezogenen Daten nicht mehr verarbeiten, es sei denn, wir können zwingende schutz&shy;würdige Gründe für die Verarbeitung nachweisen, die Ihre Interessen, Rechte und Freiheiten überwiegen, oder die Verarbeitung dient der Geltendmachung, Ausübung oder Verteidigung von Rechts&shy;ansprüchen <span class="mono privacy-callout__cite">(Art.&nbsp;21 Abs.&nbsp;1 DSGVO)</span>.</p>
                            <p><strong>Werden Ihre personen&shy;bezogenen Daten verarbeitet, um Direkt&shy;werbung zu betreiben</strong>, so haben Sie das Recht, jederzeit Widerspruch gegen die Verarbeitung Sie betreffender personen&shy;bezogener Daten zum Zwecke derartiger Werbung einzulegen; dies gilt auch für das Profiling, soweit es mit solcher Direkt&shy;werbung in Verbindung steht. Wenn Sie widersprechen, werden Ihre personen&shy;bezogenen Daten anschließend nicht mehr zum Zwecke der Direkt&shy;werbung verwendet <span class="mono privacy-callout__cite">(Art.&nbsp;21 Abs.&nbsp;2 DSGVO)</span>.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub" id="beschwerde">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">3.8</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Beschwerderecht bei der zuständigen Aufsichtsbehörde</h3>
                        <div class="privacy-prose">
                            <p>Im Falle von Verstößen gegen die DSGVO steht den Betroffenen ein Beschwerderecht bei einer Aufsichts&shy;behörde zu, insbesondere in dem Mitglied&shy;staat ihres gewöhnlichen Aufenthalts, ihres Arbeits&shy;platzes oder des Orts des mutmaßlichen Verstoßes. Das Beschwerderecht besteht unbeschadet anderweitiger verwaltungs&shy;rechtlicher oder gerichtlicher Rechtsbehelfe.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">3.9</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Recht auf Datenübertragbarkeit</h3>
                        <div class="privacy-prose">
                            <p>Sie haben das Recht, Daten, die wir auf Grundlage Ihrer Einwilligung oder in Erfüllung eines Vertrags automatisiert verarbeiten, an sich oder an einen Dritten in einem gängigen, maschinen&shy;lesbaren Format aushändigen zu lassen. Sofern Sie die direkte Übertragung der Daten an einen anderen Verantwortlichen verlangen, erfolgt dies nur, soweit es technisch machbar ist.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">3.10</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Auskunft, Berichtigung und Löschung</h3>
                        <div class="privacy-prose">
                            <p>Sie haben im Rahmen der geltenden gesetzlichen Bestimmungen jederzeit das Recht auf unentgeltliche Auskunft über Ihre gespeicherten personen&shy;bezogenen Daten, deren Herkunft und Empfänger und den Zweck der Datenverarbeitung und ggf. ein Recht auf Berichtigung oder Löschung dieser Daten. Hierzu sowie zu weiteren Fragen können Sie sich jederzeit an uns wenden.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">3.11</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Recht auf Einschränkung der Verarbeitung</h3>
                        <div class="privacy-prose">
                            <p>Sie haben das Recht, die Einschränkung der Verarbeitung Ihrer personen&shy;bezogenen Daten zu verlangen. Hierzu können Sie sich jederzeit an uns wenden. Das Recht auf Einschränkung der Verarbeitung besteht in folgenden Fällen:</p>
                            <ul class="privacy-prose__ul">
                                <li>Wenn Sie die Richtigkeit Ihrer bei uns gespeicherten personen&shy;bezogenen Daten bestreiten, benötigen wir in der Regel Zeit, um dies zu überprüfen. Für die Dauer der Prüfung haben Sie das Recht, die Einschränkung zu verlangen.</li>
                                <li>Wenn die Verarbeitung Ihrer personen&shy;bezogenen Daten unrechtmäßig geschah/geschieht, können Sie statt der Löschung die Einschränkung verlangen.</li>
                                <li>Wenn wir Ihre personen&shy;bezogenen Daten nicht mehr benötigen, Sie sie jedoch zur Ausübung, Verteidigung oder Geltendmachung von Rechts&shy;ansprüchen benötigen, haben Sie das Recht, statt der Löschung die Einschränkung zu verlangen.</li>
                                <li>Wenn Sie einen Widerspruch nach Art.&nbsp;21 Abs.&nbsp;1 DSGVO eingelegt haben, muss eine Abwägung zwischen Ihren und unseren Interessen vorgenommen werden. Solange noch nicht feststeht, wessen Interessen überwiegen, haben Sie das Recht, die Einschränkung zu verlangen.</li>
                            </ul>
                            <p>Wenn Sie die Verarbeitung Ihrer personen&shy;bezogenen Daten eingeschränkt haben, dürfen diese Daten — von ihrer Speicherung abgesehen — nur mit Ihrer Einwilligung oder zur Geltendmachung, Ausübung oder Verteidigung von Rechts&shy;ansprüchen oder zum Schutz der Rechte einer anderen natürlichen oder juristischen Person oder aus Gründen eines wichtigen öffentlichen Interesses der Europäischen Union oder eines Mitglied&shy;staats verarbeitet werden.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">3.12</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">SSL- bzw. TLS-Verschlüsselung</h3>
                        <div class="privacy-prose">
                            <p>Diese Seite nutzt aus Sicherheits&shy;gründen und zum Schutz der Übertragung vertraulicher Inhalte eine SSL- bzw. TLS-Verschlüsselung. Eine verschlüsselte Verbindung erkennen Sie daran, dass die Adresszeile des Browsers von <span class="mono">„http://"</span> auf <span class="mono">„https://"</span> wechselt und an dem Schloss-Symbol in Ihrer Browserzeile.</p>
                            <p>Wenn die SSL- bzw. TLS-Verschlüsselung aktiviert ist, können die Daten, die Sie an uns übermitteln, nicht von Dritten mitgelesen werden.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">3.13</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Verschlüsselter Zahlungsverkehr</h3>
                        <div class="privacy-prose">
                            <p>Besteht nach dem Abschluss eines kostenpflichtigen Vertrags eine Verpflichtung, uns Ihre Zahlungsdaten zu übermitteln, werden diese Daten zur Zahlungs&shy;abwicklung benötigt.</p>
                            <p>Der Zahlungs&shy;verkehr über die gängigen Zahlungs&shy;mittel (Visa/MasterCard, Lastschrift&shy;verfahren) erfolgt ausschließlich über eine verschlüsselte SSL- bzw. TLS-Verbindung. Bei verschlüsselter Kommunikation können Ihre Zahlungsdaten nicht von Dritten mitgelesen werden.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">3.14</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Widerspruch gegen Werbe-E-Mails</h3>
                        <div class="privacy-prose">
                            <p>Der Nutzung von im Rahmen der Impressums&shy;pflicht veröffentlichten Kontaktdaten zur Übersendung von nicht ausdrücklich angeforderter Werbung und Informations&shy;materialien wird hiermit widersprochen. Die Betreiber der Seiten behalten sich ausdrücklich rechtliche Schritte im Falle der unverlangten Zusendung von Werbe&shy;informationen, etwa durch Spam-E-Mails, vor.</p>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        {{-- ----------------- Chapter 4 ----------------- --}}
        <section class="privacy-chapter" id="datenerfassung">
            <div class="privacy-chapter__head">
                <span class="privacy-chapter__num">KAPITEL&nbsp;04</span>
                <span class="privacy-chapter__rule" aria-hidden="true"></span>
            </div>
            <h2 class="privacy-chapter__title">Datenerfassung auf dieser Website</h2>

            <div class="privacy-chapter__subs">
                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">4.1</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Cookies</h3>
                        <div class="privacy-prose">
                            <p>Unsere Internetseiten verwenden so genannte „Cookies". Cookies sind kleine Datenpakete und richten auf Ihrem Endgerät keinen Schaden an. Sie werden entweder vorübergehend für die Dauer einer Sitzung (Session-Cookies) oder dauerhaft (permanente Cookies) auf Ihrem Endgerät gespeichert.</p>
                        </div>
                        <div class="privacy-cookie-grid">
                            @foreach ($cookieTypes as [$label, $desc])
                                <div class="privacy-cookie-grid__cell">
                                    <span class="privacy-cookie-grid__label">{{ $label }}</span>
                                    <p class="privacy-cookie-grid__desc">{!! $desc !!}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="privacy-prose">
                            <p>Cookies, die zur Durchführung des elektronischen Kommunikations&shy;vorgangs, zur Bereitstellung bestimmter, von Ihnen erwünschter Funktionen oder zur Optimierung der Website erforderlich sind (notwendige Cookies), werden auf Grundlage von Art.&nbsp;6 Abs.&nbsp;1 lit.&nbsp;f DSGVO gespeichert. Sofern eine Einwilligung zur Speicherung von Cookies und vergleichbaren Wieder&shy;erkennungs&shy;technologien abgefragt wurde, erfolgt die Verarbeitung ausschließlich auf Grundlage dieser Einwilligung (Art.&nbsp;6 Abs.&nbsp;1 lit.&nbsp;a DSGVO und §&nbsp;25 Abs.&nbsp;1 TDDDG); die Einwilligung ist jederzeit widerrufbar.</p>
                            <p>Sie können Ihren Browser so einstellen, dass Sie über das Setzen von Cookies informiert werden und Cookies nur im Einzelfall erlauben, die Annahme von Cookies für bestimmte Fälle oder generell ausschließen sowie das automatische Löschen der Cookies beim Schließen des Browsers aktivieren. Bei der Deaktivierung von Cookies kann die Funktionalität dieser Website eingeschränkt sein.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">4.2</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Server-Log-Dateien</h3>
                        <div class="privacy-prose">
                            <p>Der Provider der Seiten erhebt und speichert automatisch Informationen in so genannten Server-Log-Dateien, die Ihr Browser automatisch an uns übermittelt. Dies sind:</p>
                        </div>
                        <ul class="privacy-log-fields">
                            @foreach ($logFields as $field)
                                <li><span class="privacy-log-fields__bullet" aria-hidden="true">·</span>{{ $field }}</li>
                            @endforeach
                        </ul>
                        <div class="privacy-prose">
                            <p>Eine Zusammenführung dieser Daten mit anderen Datenquellen wird nicht vorgenommen.</p>
                            <p>Die Erfassung dieser Daten erfolgt auf Grundlage von Art.&nbsp;6 Abs.&nbsp;1 lit.&nbsp;f DSGVO. Der Website&shy;betreiber hat ein berechtigtes Interesse an der technisch fehlerfreien Darstellung und der Optimierung seiner Website — hierzu müssen die Server-Log-Files erfasst werden.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub" id="kontaktformular">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">4.3</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Kontaktformular</h3>
                        <div class="privacy-prose">
                            <p>Wenn Sie uns per Kontaktformular Anfragen zukommen lassen, werden Ihre Angaben aus dem Anfrageformular inklusive der von Ihnen dort angegebenen Kontaktdaten zwecks Bearbeitung der Anfrage und für den Fall von Anschlussfragen bei uns gespeichert. Diese Daten geben wir nicht ohne Ihre Einwilligung weiter.</p>
                            <p>Die Verarbeitung dieser Daten erfolgt auf Grundlage von Art.&nbsp;6 Abs.&nbsp;1 lit.&nbsp;b DSGVO, sofern Ihre Anfrage mit der Erfüllung eines Vertrags zusammenhängt oder zur Durchführung vorvertraglicher Maßnahmen erforderlich ist. In allen übrigen Fällen beruht die Verarbeitung auf unserem berechtigten Interesse an der effektiven Bearbeitung der an uns gerichteten Anfragen (Art.&nbsp;6 Abs.&nbsp;1 lit.&nbsp;f DSGVO) oder auf Ihrer Einwilligung (Art.&nbsp;6 Abs.&nbsp;1 lit.&nbsp;a DSGVO).</p>
                            <p>Die von Ihnen im Kontaktformular eingegebenen Daten verbleiben bei uns, bis Sie uns zur Löschung auffordern, Ihre Einwilligung zur Speicherung widerrufen oder der Zweck für die Datenspeicherung entfällt.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">4.4</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Anfrage per E-Mail, Telefon oder Telefax</h3>
                        <div class="privacy-prose">
                            <p>Wenn Sie uns per E-Mail, Telefon oder Telefax kontaktieren, wird Ihre Anfrage inklusive aller daraus hervorgehenden personen&shy;bezogenen Daten (Name, Anfrage) zum Zwecke der Bearbeitung Ihres Anliegens bei uns gespeichert und verarbeitet. Diese Daten geben wir nicht ohne Ihre Einwilligung weiter.</p>
                            <p>Die Verarbeitung dieser Daten erfolgt auf Grundlage von Art.&nbsp;6 Abs.&nbsp;1 lit.&nbsp;b DSGVO, sofern Ihre Anfrage mit der Erfüllung eines Vertrags zusammenhängt oder zur Durchführung vorvertraglicher Maßnahmen erforderlich ist. In allen übrigen Fällen beruht die Verarbeitung auf unserem berechtigten Interesse oder auf Ihrer Einwilligung.</p>
                            <p>Die von Ihnen an uns per Kontakt&shy;anfragen übersandten Daten verbleiben bei uns, bis Sie uns zur Löschung auffordern, Ihre Einwilligung zur Speicherung widerrufen oder der Zweck für die Datenspeicherung entfällt.</p>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        {{-- ----------------- Chapter 5 ----------------- --}}
        <section class="privacy-chapter" id="newsletter">
            <div class="privacy-chapter__head">
                <span class="privacy-chapter__num">KAPITEL&nbsp;05</span>
                <span class="privacy-chapter__rule" aria-hidden="true"></span>
            </div>
            <h2 class="privacy-chapter__title">Newsletter</h2>

            <div class="privacy-chapter__subs">
                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">5.1</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Newsletterdaten</h3>
                        <div class="privacy-prose">
                            <p>Wenn Sie den auf der Website angebotenen Newsletter beziehen möchten, benötigen wir von Ihnen eine E-Mail-Adresse sowie Informationen, welche uns die Überprüfung gestatten, dass Sie der Inhaber der angegebenen E-Mail-Adresse sind und mit dem Empfang des Newsletters einverstanden sind. Weitere Daten werden nicht bzw. nur auf freiwilliger Basis erhoben. Diese Daten verwenden wir ausschließlich für den Versand der angeforderten Informationen und geben diese nicht an Dritte weiter.</p>
                            <p>Die Verarbeitung der in das Newsletter&shy;anmelde&shy;formular eingegebenen Daten erfolgt ausschließlich auf Grundlage Ihrer Einwilligung (Art.&nbsp;6 Abs.&nbsp;1 lit.&nbsp;a DSGVO). Die erteilte Einwilligung können Sie jederzeit widerrufen, etwa über den „Austragen"-Link im Newsletter.</p>
                            <p>Die von Ihnen zum Zwecke des Newsletter-Bezugs bei uns hinterlegten Daten werden von uns bis zu Ihrer Austragung aus dem Newsletter bei uns bzw. dem Newsletter&shy;dienste&shy;anbieter gespeichert und nach der Abbestellung des Newsletters oder nach Zweckfortfall aus der Newsletter&shy;verteilerliste gelöscht.</p>
                            <p>Nach Ihrer Austragung aus der Newsletter&shy;verteilerliste wird Ihre E-Mail-Adresse bei uns bzw. dem Newsletter&shy;dienste&shy;anbieter ggf. in einer Blacklist gespeichert, sofern dies zur Verhinderung künftiger Mailings erforderlich ist. <strong>Sie können der Speicherung widersprechen, sofern Ihre Interessen unser berechtigtes Interesse überwiegen.</strong></p>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        {{-- ----------------- Chapter 6 ----------------- --}}
        <section class="privacy-chapter" id="ecommerce">
            <div class="privacy-chapter__head">
                <span class="privacy-chapter__num">KAPITEL&nbsp;06</span>
                <span class="privacy-chapter__rule" aria-hidden="true"></span>
            </div>
            <h2 class="privacy-chapter__title">eCommerce und Zahlungsanbieter</h2>

            <div class="privacy-chapter__subs">
                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">6.1</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Verarbeiten von Kunden- und Vertragsdaten</h3>
                        <div class="privacy-prose">
                            <p>Wir erheben, verarbeiten und nutzen personen&shy;bezogene Kunden- und Vertragsdaten zur Begründung, inhaltlichen Ausgestaltung und Änderung unserer Vertrags&shy;beziehungen. Personen&shy;bezogene Daten über die Inanspruchnahme dieser Website (Nutzungs&shy;daten) erheben, verarbeiten und nutzen wir nur, soweit dies erforderlich ist, um dem Nutzer die Inanspruchnahme des Dienstes zu ermöglichen oder abzurechnen. Rechts&shy;grundlage hierfür ist Art.&nbsp;6 Abs.&nbsp;1 lit.&nbsp;b DSGVO.</p>
                            <p>Die erhobenen Kundendaten werden nach Abschluss des Auftrags oder Beendigung der Geschäfts&shy;beziehung und Ablauf der ggf. bestehenden gesetzlichen Aufbewahrungs&shy;fristen gelöscht. Gesetzliche Aufbewahrungs&shy;fristen bleiben unberührt.</p>
                        </div>
                    </div>
                </article>

                <article class="privacy-sub">
                    <div class="privacy-sub__rail"><span class="privacy-sub__eyebrow">6.2</span></div>
                    <div class="privacy-sub__content">
                        <h3 class="privacy-sub__title">Datenübermittlung bei Vertragsschluss für Dienstleistungen und digitale Inhalte</h3>
                        <div class="privacy-prose">
                            <p>Wir übermitteln personen&shy;bezogene Daten an Dritte nur dann, wenn dies im Rahmen der Vertrags&shy;abwicklung notwendig ist, etwa an das mit der Zahlungs&shy;abwicklung beauftragte Kreditinstitut.</p>
                            <p>Eine weitergehende Übermittlung der Daten erfolgt nicht bzw. nur dann, wenn Sie der Übermittlung ausdrücklich zugestimmt haben. Eine Weitergabe Ihrer Daten an Dritte ohne ausdrückliche Einwilligung, etwa zu Zwecken der Werbung, erfolgt nicht.</p>
                            <p>Grundlage für die Datenverarbeitung ist Art.&nbsp;6 Abs.&nbsp;1 lit.&nbsp;b DSGVO, der die Verarbeitung von Daten zur Erfüllung eines Vertrags oder vorvertraglicher Maßnahmen gestattet.</p>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <div class="privacy-closing">
            <div class="privacy-closing__rail"><span class="eyebrow">Hinweis</span></div>
            <p class="caption privacy-closing__body">
                Audania ist kein Medizin&shy;produkt im Sinne der MDR (Verordnung (EU) 2017/745).
                Die Plattform liefert keine Diagnose, keine Triage und keine
                Therapie&shy;empfehlung — sie strukturiert ausschließlich die Anamnese
                vor dem Arzt&shy;gespräch. Diese Datenschutz&shy;erklärung erläutert,
                wie die dabei anfallenden Daten verarbeitet werden.
            </p>
        </div>
    </div>
</main>
