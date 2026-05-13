@php
    $rows = [
        ['vs' => 'Idana',                                'they' => 'Klassischer digitaler Anamnese-Bogen. Sehr umfassend, aber kein freies Sprechen — die Patient:in füllt vorgegebene Felder aus.', 'us' => 'Audania führt das Gespräch in eigenen Worten der Patient:in. Vergleichbare Datenschutz-Posture, kein Doctolib-Paket-Zwang.'],
        ['vs' => 'Nelly',                                'they' => 'Anamnese ist dort Teil eines größeren Bezahl- und Factoring-Pakets.',                                                          'us' => 'Bei Audania ist die Anamnese das Kernprodukt — keine Verknüpfung mit Bezahlung, kein Factoring.'],
        ['vs' => 'symptoX',                              'they' => 'Sprach-gesteuert im Wartezimmer. Im realen Lärm und mit älteren Patient:innen schwierig — und schwer nachvollziehbar, was das Gerät verstanden hat.', 'us' => 'Audania ist text-basiert; gesprochene Eingabe ist optional. Jeder Befund ist nachvollziehbar, jede Antwort wortgenau.'],
        ['vs' => 'Doctolib + Idana',                     'they' => 'Im Paket angeboten, mit Bindung an das Doctolib-Buchungssystem und Hosting in Frankreich.',                                    'us' => 'Audania erfordert keinen Wechsel Ihrer Praxissoftware. Wir sprechen mit der Software, die Sie heute schon nutzen.'],
        ['vs' => 'Ada · Infermedica',                    'they' => 'Symptom-Checker mit MDR-Zertifizierung. Gibt Verdachtsdiagnosen und Dringlichkeits-Stufen aus.',                                'us' => 'Audania ist bewusst kein Medizinprodukt — keine Diagnosen, keine Triage. Das macht Audania schneller in der Praxis und überlässt die ärztliche Beurteilung der Ärzt:in.'],
        ['vs' => 'CGM AmbulApps · medatixx HealthHub',   'they' => 'An die jeweilige Praxissoftware gebunden, verdrängt Wettbewerb im Paket.',                                                     'us' => 'Audania spricht mit allen großen Praxissoftware-Systemen. Wir verdrängen nichts, und wir binden Sie nicht an uns.'],
    ];
    $last = count($rows) - 1;
@endphp

<section class="marketing-vs" data-screen-label="05 Position">
    <div class="marketing-vs__inner">
        <div class="section-head">
            <div>
                <span class="eyebrow" style="color: var(--color-clay);">Position</span>
                <h2 class="vs-title">Wo Audania steht.</h2>
            </div>
            <p class="vs-lede">
                Sechs Vergleiche — direkt und ohne Marketing-Schleier. Damit Sie wissen,
                wofür Audania steht und was es nicht ist.
            </p>
        </div>

        <div>
            @foreach ($rows as $i => $row)
                <div @class(['vs-row', 'is-last' => $i === $last])>
                    <div class="vs-row__name">vs. {{ $row['vs'] }}</div>
                    <div class="vs-row__they">{{ $row['they'] }}</div>
                    <div class="vs-row__us">{{ $row['us'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>