@php
    $steps = [
        [
            'n' => '01',
            'title' => 'Check-in. Patient:in erhält einen Code.',
            'body' => 'Beim Check-in oder per SMS-Link öffnet die Patient:in Audania auf dem Praxis-Tablet oder dem eigenen Telefon. Kein Login, keine App-Installation — ein Einmalcode genügt.',
            'bullet' => 'Tablet oder QR · 6-stelliger Sitzungscode',
        ],
        [
            'n' => '02',
            'title' => 'Strukturierte Anamnese in eigenen Worten.',
            'body' => 'Audania stellt eine Frage nach der anderen — ein Gedanke pro Frage. Die Antworten werden in den eigenen Worten der Patient:in gespeichert, nicht paraphrasiert. Welche Fragen gestellt werden, hängt vom Anliegen ab — Rückenschmerzen anders als Bauchschmerzen.',
            'bullet' => '12 strukturierte Fragen · 4–7 Minuten · 10+ Sprachen',
        ],
        [
            'n' => '03',
            'title' => 'Befund liegt vor dem Gespräch in Ihrer Praxissoftware.',
            'body' => 'Bevor die Patient:in ins Sprechzimmer gerufen wird, ist der strukturierte Anamnese-Befund in Ihrer Praxissoftware — sortiert nach Anliegen, Verlauf, Charakter, Intensität, Vorgeschichte und Medikation.',
            'bullet' => 'Übergabe an medatixx, CGM Albis, Turbomed, Medistar',
        ],
    ];
@endphp

<section id="how" class="marketing-how" data-screen-label="02 So funktioniert es">
    <div class="section-head">
        <div>
            <span class="eyebrow">So funktioniert es</span>
            <h2 class="h1 section-head__title">
                Drei Schritte, ehe der Patient aufgerufen wird.
            </h2>
        </div>
        <p class="section-head__lede">
            Audania verändert nichts an Ihrem Praxisablauf — außer dass die
            Anamnese fertig ist, bevor der Patient ins Sprechzimmer kommt.
            Sie wechseln Ihre Praxissoftware nicht. Sie binden sich an kein
            Buchungssystem. Audania ist kein Bezahl-Anbieter.
        </p>
    </div>

    <div class="steps">
        @foreach ($steps as $step)
            <article class="step-card">
                <span class="step-card__num">{{ $step['n'] }}</span>
                <h3 class="step-card__title">{{ $step['title'] }}</h3>
                <p class="step-card__body">{{ $step['body'] }}</p>
                <div style="flex: 1;"></div>
                <span class="step-card__bullet">{{ $step['bullet'] }}</span>
            </article>
        @endforeach
    </div>
</section>