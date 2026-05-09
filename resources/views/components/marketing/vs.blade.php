@php
    $rows = [
        ['vs' => 'Idana',                                'they' => 'Deterministisches Formular. 400+ Bögen, kein Conversational AI.',          'us' => 'Audania ist gesprächsbasiert. Gleiche Compliance-Posture, kein Doctolib-Lock-in.'],
        ['vs' => 'Nelly',                                'they' => 'Anamnese als Funnel-Eingang für Payment und Factoring.',                  'us' => 'Bei Audania ist die Anamnese das Kernprodukt — kein Health-Fintech mit Anamnese im Beipack.'],
        ['vs' => 'symptoX',                              'they' => 'Voice-first im Wartezimmer. Schwer evaluierbar, schwer reproduzierbar.', 'us' => 'Audania ist text-first, mit Voice als optionalem Add-on. Audit-fähiger Befund.'],
        ['vs' => 'Doctolib + Idana',                     'they' => 'Gebündelt, mit Booking-Lock-in und Hosting in Frankreich.',               'us' => 'Audania erfordert keinen PVS-Wechsel. Wir reden mit Ihrem PVS, wir ersetzen es nicht.'],
        ['vs' => 'Ada · Infermedica',                    'they' => 'Symptom-Checker mit MDR Class IIa / IIb.',                                'us' => 'Audania ist bewusst kein Medizinprodukt. Genau deshalb in Wochen, nicht in MDR-Zyklen.'],
        ['vs' => 'CGM AmbulApps · medatixx HealthHub',   'they' => 'PVS-eigen, verdrängt Konkurrenz im Bundle.',                              'us' => 'Audania ist PVS-neutral. Wir reden mit Ihrem PVS, wir verdrängen es nicht.'],
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
                Sechs Vergleiche, die jede UX-, Copy- und Architektur-Entscheidung bestehen muss.
                Wir lesen sie offen, weil unsere Position vom Kontrast lebt.
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