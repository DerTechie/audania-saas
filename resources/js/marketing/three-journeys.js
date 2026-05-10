/**
 * Audania — Drei Patientenpfade animation.
 *
 * Three lanes (Patient | LLM Slot-Fill | Policy) play the same architecture
 * across three patient journeys. Across language, age, and symptom, the
 * pipeline stays constant. The LLM converts unstructured text → JSON.
 * Everything else — next question, red-flag matching, schema selection —
 * is deterministic policy.
 *
 * Mounts on `[data-three-journeys]`. Looks up sub-regions by data-attribute.
 *
 * Each region keeps its own cache key and only re-renders when *that*
 * region's state actually changes. Within a phase group, sub-elements
 * (typed text, JSON line opacity, slot tick-ons, next-step card state)
 * are mutated imperatively so keyframe animations don't re-fire on every
 * unrelated tick.
 */

const SCHEMAS = {
    'abdomen-adult': {
        label: 'Bauchschmerzen · Erwachsene',
        required: [
            { key: 'onset', de: 'Beginn' },
            { key: 'location', de: 'Ort' },
            { key: 'character', de: 'Charakter' },
            { key: 'severity', de: 'Intensität' },
            { key: 'triggers', de: 'Auslöser' },
            { key: 'associated', de: 'Begleitsymptome' },
            { key: 'prior_episodes', de: 'Vorepisoden' },
            { key: 'meds', de: 'Medikation' },
            { key: 'allergies', de: 'Allergien' },
        ],
    },
    'ent-pediatric': {
        label: 'Halsschmerzen · Pädiatrie',
        required: [
            { key: 'onset', de: 'Beginn' },
            { key: 'fever_temp_c', de: 'Temperatur' },
            { key: 'associated', de: 'Begleitsymptome' },
            { key: 'hydration_signs', de: 'Trinkverhalten' },
            { key: 'behavior_change', de: 'Verhalten' },
            { key: 'swallowing', de: 'Schlucken' },
            { key: 'breathing', de: 'Atmung' },
            { key: 'meds', de: 'Medikation' },
            { key: 'allergies', de: 'Allergien' },
        ],
    },
};

const JOURNEYS = [
    {
        id: 'j1-schneider',
        label: 'Frau Schneider',
        sub: '67 · deutsche Muttersprachlerin',
        lang: 'de',
        schema: 'abdomen-adult',
        initialRole: 'self',
        intro: 'Eine ruhige Anamnese in einer Sprache, ohne Komplikationen. Die einfachste Form der Architektur.',
        steps: [
            {
                ask: 'Was führt Sie heute zu uns? Beschreiben Sie es bitte in eigenen Worten.',
                utterance:
                    'Ich hab seit drei Tagen so ein Drücken im Oberbauch, vor allem nach dem Essen. Übelkeit auch.',
                utteranceLang: 'de',
                typeMs: 26,
                patch: [
                    { key: 'onset', value: '"P3D"', evidence: 'seit drei Tagen' },
                    { key: 'location', value: '"upper"', evidence: 'Oberbauch' },
                    { key: 'character', value: '"dull"', evidence: 'Drücken' },
                    { key: 'triggers', value: '["eating"]', evidence: 'nach dem Essen' },
                    { key: 'associated', value: '["nausea"]', evidence: 'Übelkeit' },
                ],
                nextAsk: 'Auf einer Skala von 1 bis 10 — wie stark ist das Drücken im Moment?',
                caption:
                    'Ein Satz. Sechs Slots. Das Modell antwortet nicht der Patientin — es liefert nur strukturiertes JSON zurück, mit Belegzitaten zu jedem Wert.',
            },
            {
                ask: 'Auf einer Skala von 1 bis 10 — wie stark ist das Drücken im Moment?',
                utterance: 'Vielleicht ne 6.',
                utteranceLang: 'de',
                typeMs: 60,
                patch: [{ key: 'severity', value: '6', evidence: 'ne 6' }],
                nextAsk: 'Welche Medikamente nehmen Sie zur Zeit regelmäßig ein?',
                caption: 'Die Policy wählt die nächste Frage anhand der noch offenen Pflicht-Slots — nie das Modell.',
            },
        ],
    },
    {
        id: 'j2-yilmaz',
        label: 'Herr Yılmaz',
        sub: '42 · türkische Erstsprache',
        lang: 'tr',
        schema: 'abdomen-adult',
        initialRole: 'self',
        intro: 'Dieselbe Policy. Andere Sprache. Das Modell ist die Brücke zwischen Eingabe in beliebiger Sprache und englisch-sprachigem Slot-Schema.',
        steps: [
            {
                ask: 'Bugün sizi bize getiren şikayet nedir? Lütfen kendi kelimelerinizle anlatın.',
                askDe: '(Was führt Sie heute zu uns? In Ihren eigenen Worten.)',
                utterance: 'karnım ağrıyor 2 gündür, dün gece kustum, ateş 38.5',
                utteranceLang: 'tr',
                utteranceDe: '(Bauchschmerzen seit zwei Tagen, gestern Nacht erbrochen, Fieber 38,5.)',
                typeMs: 38,
                patch: [
                    { key: 'onset', value: '"P2D"', evidence: '2 gündür' },
                    { key: 'associated', value: '["vomiting","fever"]', evidence: 'kustum, ateş' },
                    { key: 'fever_temp_c', value: '38.5', evidence: '38.5' },
                ],
                nextAsk: 'Ağrı karnınızın hangi bölgesinde? Üst, alt, sağ, sol, ortada veya yaygın bir yerde?',
                nextAskDe: '(In welchem Teil des Bauches? Oben, unten, rechts, links, mittig oder diffus?)',
                caption: 'Türkische Eingabe → englisch-sprachige Slots. Eine Policy, zehn Sprachen — keine zweite Dialog-Engine.',
            },
            {
                ask: 'Ağrı karnınızın hangi bölgesinde? Üst, alt, sağ, sol, ortada veya yaygın bir yerde?',
                askDe: '(In welchem Teil des Bauches?)',
                utterance: 'sağ alt',
                utteranceLang: 'tr',
                utteranceDe: '(rechts unten)',
                typeMs: 110,
                patch: [{ key: 'location', value: '"lower_right"', evidence: 'sağ alt' }],
                redFlag: {
                    id: 'lower_right_fever_vomiting',
                    parts: ['lower_right', 'fever', 'vomiting'],
                    priority: 'elevated',
                    disclaimer:
                        'Wenn sich Ihr Zustand bis zum Termin deutlich verschlechtert, wenden Sie sich bitte direkt an die Praxis oder im Notfall an den ärztlichen Notdienst (116 117) bzw. die 112.',
                },
                caption:
                    'Konstellation rechts-unten + Fieber + Erbrechen. Die Policy setzt ein Flag, hebt die Fall-Priorität an, zeigt einen statischen, von der Praxis genehmigten Hinweis. Das Modell hat das Wort »Appendizitis« nie gesehen — es gibt diesen Slot nicht.',
            },
        ],
    },
    {
        id: 'j3-lena',
        label: 'Lena, 8',
        sub: 'Mutter beantwortet stellvertretend',
        lang: 'de',
        schema: 'abdomen-adult',
        initialRole: null,
        intro: 'Stellvertreter-Eingabe, dynamischer Schema-Wechsel und temporales Parsing — drei Dinge, die deterministische Formulare schwerfallen.',
        steps: [
            {
                kind: 'policy-only',
                ask: 'Wer beantwortet die Fragen heute?',
                choices: ['Ich selbst', 'Für jemand anderen'],
                chosen: 'Für jemand anderen',
                directPatch: [{ key: 'patient_role', value: '"guardian"', evidence: 'Auswahl' }],
                caption:
                    'Diese Frage steht in der Policy ganz vorn — vor jedem Beschwerdebild. Kein Modell-Call: feste Auswahl, deterministische Zuweisung.',
            },
            {
                ask: 'Bitte beschreiben Sie kurz, was los ist.',
                utterance: 'Ich bin Lenas Mutter, sie ist 8 und hat seit heute Morgen Halsschmerzen und Fieber. Sie kriegt schlecht Luft.',
                utteranceLang: 'de',
                typeMs: 24,
                patch: [
                    { key: 'patient_relation', value: '"mother"', evidence: 'Lenas Mutter' },
                    { key: 'patient_first', value: '"Lena"', evidence: 'Lenas' },
                    { key: 'patient_age', value: '8', evidence: 'ist 8' },
                    { key: 'chief_complaint', value: '"sore_throat"', evidence: 'Halsschmerzen' },
                    { key: 'onset', value: '"PT6H"', evidence: 'seit heute Morgen' },
                    {
                        key: 'associated',
                        value: '["fever","breathing_difficulty"]',
                        evidence: 'Fieber … schlecht Luft',
                    },
                ],
                schemaSwap: 'ent-pediatric',
                redFlag: {
                    id: 'pediatric_breathing_difficulty',
                    parts: ['age<12', 'breathing_difficulty'],
                    priority: 'elevated',
                    disclaimer: 'Bei zunehmender Atemnot bitte umgehend die Praxis kontaktieren oder 112 wählen.',
                },
                nextAsk: 'Welche Temperatur habt ihr gemessen, und wann zuletzt?',
                caption:
                    'Alter 8 → die Policy lädt das pädiatrische Schema; andere Pflicht-Slots werden aktiv. Atemnot trifft eine pädiatrische Konstellation — die Priorität wird angehoben.',
            },
            {
                ask: 'Welche Temperatur habt ihr gemessen, und wann zuletzt?',
                utterance: '39 grad seit ner stunde, hatte vorher 38',
                utteranceLang: 'de',
                typeMs: 50,
                patch: [
                    { key: 'fever_temp_c.current', value: '39.0', evidence: '39 grad' },
                    {
                        key: 'fever_temp_c.history',
                        value: '[{38.0, earlier_today}, {39.0, PT1H}]',
                        evidence: 'vorher 38 · seit ner Stunde',
                    },
                ],
                nextAsk: 'Hat Lena heute getrunken, und wenn ja, wieviel?',
                caption: 'Casual-Text → strukturierte Zeitleiste. Genau hier ist das Modell stark und ein Formular schwach.',
            },
        ],
    },
];

const PHASE_DURATIONS = {
    ask: 1500,
    preExtract: 1100,
    extractStep: 520,
    postExtract: 1100,
    react: 3200,
    settle: 3000,
    endHold: 4800,
};

const ICON_LOCK = `<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>`;
const ICON_PLAY = `<svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><polygon points="6,4 20,12 6,20"/></svg>`;
const ICON_PAUSE = `<svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><rect x="6" y="5" width="4" height="14" rx="1"/><rect x="14" y="5" width="4" height="14" rx="1"/></svg>`;
const ICON_REPLAY = `<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>`;
const ICON_CHECK = `<svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>`;

function escapeHtml(value) {
    if (value === null || value === undefined) return '';
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

function clamp(v, lo, hi) {
    return Math.max(lo, Math.min(hi, v));
}

function truncate(s, n) {
    if (!s) return '';
    return s.length > n ? s.slice(0, n - 1) + '…' : s;
}

function laneForPhase(phase, step) {
    if (step && step.kind === 'policy-only') {
        if (phase === 'react') return 'patient';
        return 'policy';
    }
    switch (phase) {
        case 'ask':
        case 'type':
            return 'patient';
        case 'extract':
            return 'llm';
        case 'react':
        case 'settle':
        case 'done':
            return 'policy';
        default:
            return null;
    }
}

function composePolicyState(journey, n) {
    let schemaId = journey.schema;
    let role = journey.initialRole;
    const filled = new Set();
    let redFlag = null;
    let priority = 'normal';
    let nextAsk = journey.steps[0]?.ask || null;

    for (let i = 0; i < n; i++) {
        const s = journey.steps[i];
        if (!s) break;
        if (s.schemaSwap) schemaId = s.schemaSwap;
        if (s.kind === 'policy-only' && s.directPatch) {
            s.directPatch.forEach((p) => {
                if (p.key === 'patient_role') role = p.value.replace(/^"|"$/g, '');
            });
        }
        if (s.patch) {
            s.patch.forEach((p) => filled.add(p.key.split('.')[0]));
        }
        if (s.redFlag) {
            redFlag = s.redFlag;
            priority = s.redFlag.priority || priority;
        }
        if (s.nextAsk) nextAsk = s.nextAsk;
    }
    return { schemaId, role, filled, redFlag, priority, nextAsk };
}

function phaseFraction(p) {
    switch (p) {
        case 'ask':
            return 0.1;
        case 'type':
            return 0.35;
        case 'extract':
            return 0.6;
        case 'react':
            return 0.85;
        case 'settle':
            return 0.98;
        case 'done':
            return 1.0;
        default:
            return 0;
    }
}

function phaseLabel(p) {
    switch (p) {
        case 'ask':
            return 'Frage';
        case 'type':
            return 'Eingabe';
        case 'extract':
            return 'Modell-Antwort';
        case 'react':
            return 'Policy reagiert';
        case 'settle':
            return 'Pause';
        case 'done':
            return 'fertig';
        default:
            return '—';
    }
}

// Phase groups for keying lane re-renders. Within a group, sub-element state
// is mutated imperatively rather than via innerHTML rewrites — so fade-up
// animations on stable elements don't replay on every tick.
function patientGroup(phase, step) {
    // Single render per step. Visibility of the input wrap and the bubble's
    // is-done state are flipped imperatively via updatePatientLaneInPlace so
    // policy-ask doesn't re-fire its fade-up on phase transitions.
    return 'all';
}

function llmGroup(phase, step) {
    if (step && step.kind === 'policy-only') return 'po';
    if (phase === 'ask' || phase === 'type') return 'idle';
    return 'active';
}

function policyGroup(phase) {
    return phase === 'react' || phase === 'settle' || phase === 'done' ? 'reacted' : 'pre';
}

function captionGroup(phase) {
    return phase === 'extract' || phase === 'react' || phase === 'settle' || phase === 'done' ? 'visible' : 'intro';
}

function nextStepState(phase) {
    if (phase === 'settle' || phase === 'done') return 'ready';
    if (phase === 'react') return 'pulsing';
    return 'waiting';
}

// ----- Render: tabs ---------------------------------------------------------

function renderTabs(activeIdx) {
    return JOURNEYS.map((j, i) => {
        const active = i === activeIdx;
        return `
            <button class="tj-tab ${active ? 'is-active' : ''}" data-tab-idx="${i}" type="button">
                <span class="tj-tab__num">Beispiel ${i + 1}</span>
                <span class="tj-tab__label">${escapeHtml(j.label)}</span>
                <span class="tj-tab__sub">${escapeHtml(j.sub)}</span>
                ${active ? '<span class="tj-tab__underline"></span>' : ''}
            </button>
        `;
    }).join('');
}

// ----- Render: stage skeleton (mounted once) -------------------------------

function renderStageSkeleton() {
    return `
        <div class="tj-lane-headers" data-tj-lane-headers></div>
        <div class="tj-lanes">
            <div class="tj-lane tj-lane--patient" data-tj-patient></div>
            <div class="tj-lane tj-lane--llm" data-tj-llm></div>
            <div class="tj-lane tj-lane--policy" data-tj-policy></div>
        </div>
    `;
}

// ----- Render: lane headers (per step; class-toggle for active) ------------

function renderLaneHeaders() {
    const items = [
        { id: 'patient', tag: 'PATIENT', title: 'Eingabe', body: 'Was die Patient:in schreibt oder auswählt.' },
        { id: 'llm', tag: 'LLM · SLOT-FILL', title: 'Modell-Antwort', body: 'Eine Slot-Patch in JSON, mit Belegzitaten.' },
        { id: 'policy', tag: 'POLICY', title: 'Zustandsmaschine', body: 'Wählt die nächste Frage und prüft Konstellationen.' },
    ];
    return items
        .map(
            (it) => `
            <div class="tj-lane-header" data-lane-id="${it.id}">
                <span class="tj-lane-header__tag">
                    <span class="tj-lane-header__dot"></span>
                    ${escapeHtml(it.tag)}
                </span>
                <span class="tj-lane-header__title">${escapeHtml(it.title)}</span>
                <span class="tj-lane-header__body">${escapeHtml(it.body)}</span>
            </div>
        `,
        )
        .join('');
}

function applyActiveLane(stageEl, activeLane) {
    stageEl.querySelectorAll('[data-lane-id]').forEach((h) => {
        h.classList.toggle('is-active', h.dataset.laneId === activeLane);
    });
    [
        ['data-tj-patient', 'patient'],
        ['data-tj-llm', 'llm'],
        ['data-tj-policy', 'policy'],
    ].forEach(([attr, id]) => {
        const lane = stageEl.querySelector('[' + attr + ']');
        if (!lane) return;
        const isActive = id === activeLane;
        lane.classList.toggle('is-active', isActive);
        const stripe = lane.querySelector('[data-stripe]');
        if (stripe) stripe.classList.toggle('is-on', isActive);
    });
}

// ----- Render: patient lane (per pPhaseGroup) ------------------------------

function renderPatientLaneInner(journey, stepIdx, step, phase, typedChars) {
    const past = journey.steps.slice(0, stepIdx);
    const isPolicyOnly = step.kind === 'policy-only';
    const pastHtml = past.map((s) => renderPastTurn(s)).join('');

    const askHtml = `
        <div class="tj-policy-ask" data-policy-ask>
            <span class="tj-policy-ask__attribution">Audania</span>
            <p class="tj-policy-ask__text">${escapeHtml(step.ask)}</p>
            ${step.askDe ? `<span class="tj-policy-ask__translation">${escapeHtml(step.askDe)}</span>` : ''}
        </div>
    `;

    // Always render the input wrap so it stays mounted across the whole step.
    // Visibility flips via inline display, which restarts the wrap's keyframe
    // animation (intended) without re-mounting policy-ask above it.
    let inputHtml;
    if (isPolicyOnly) {
        inputHtml = renderChoicePicker(step.choices, step.chosen, phase);
    } else {
        const visible = (step.utterance || '').slice(0, typedChars);
        const isDone = phase !== 'ask' && phase !== 'type';
        const showCaret = phase === 'type';
        const showWrap = phase !== 'ask';
        inputHtml = renderUtteranceBox(
            visible,
            step.utteranceLang,
            showCaret,
            isDone,
            step.utteranceDe,
            showWrap,
        );
    }

    return `
        <span class="tj-active-stripe" data-stripe></span>
        ${renderSessionChip(journey)}
        <div class="tj-patient-stream">
            ${pastHtml}
            ${askHtml}
            ${inputHtml}
        </div>
        <div class="tj-lane-footer">
            <span class="tj-lane-footer__left">${ICON_LOCK} E2E verschlüsselt · Frankfurt</span>
            <span class="tj-lane-footer__right">Keine Diagnose.</span>
        </div>
    `;
}

function renderSessionChip(journey) {
    return `
        <div class="tj-session-chip">
            <span class="tj-session-chip__name">Praxis Dr. Reichert</span>
            <span class="tj-session-chip__lang">Sprache: ${journey.lang === 'tr' ? 'TR' : 'DE'}</span>
        </div>
    `;
}

function renderUtteranceBox(text, lang, showCaret, done, translation, showWrap) {
    const langTag = (lang || 'DE').toUpperCase();
    const wrapStyle = showWrap ? '' : 'style="display:none"';
    return `
        <div class="tj-utterance" data-utterance-wrap ${wrapStyle}>
            <div class="tj-utterance__bubble ${done ? 'is-done' : 'is-active'}" data-bubble>
                <span class="tj-utterance__lang">${escapeHtml(langTag)}</span>
                <span data-utterance>${escapeHtml(text)}</span>
                <span class="tj-utterance__caret" data-caret aria-hidden="true" ${showCaret ? '' : 'style="display:none"'}></span>
            </div>
            ${
                translation
                    ? `<span class="tj-utterance__translation" data-translation ${done ? '' : 'style="display:none"'}>${escapeHtml(translation)}</span>`
                    : ''
            }
        </div>
    `;
}

function renderChoicePicker(choices, chosen, phase) {
    const reveal = phase !== 'ask';
    return `
        <div class="tj-choices" data-choices>
            ${choices
                .map((opt) => {
                    const selected = reveal && chosen === opt;
                    return `
                        <div class="tj-choice ${selected ? 'is-selected' : ''}" data-choice="${escapeHtml(opt)}">
                            <span class="tj-choice__box"></span>
                            ${escapeHtml(opt)}
                        </div>
                    `;
                })
                .join('')}
        </div>
    `;
}

function renderPastTurn(step) {
    if (step.kind === 'policy-only') {
        return `
            <div class="tj-past-turn">
                <span class="tj-past-turn__hint">Auswahl: ${escapeHtml(step.chosen)}</span>
            </div>
        `;
    }
    return `
        <div class="tj-past-turn">
            <span class="tj-past-turn__hint">${escapeHtml(truncate(step.ask, 64))}</span>
            <div class="tj-past-turn__bubble">${escapeHtml(truncate(step.utterance || '', 100))}</div>
        </div>
    `;
}

// Within-pPhaseGroup mutations: typed text, caret visibility, bubble done
// state, translation reveal, choice selection. No DOM destruction.
function updatePatientLaneInPlace(laneEl, step, phase, typedChars) {
    if (step.kind === 'policy-only') {
        const chosen = step.chosen;
        const reveal = phase !== 'ask';
        laneEl.querySelectorAll('[data-choice]').forEach((el) => {
            el.classList.toggle('is-selected', reveal && el.dataset.choice === chosen);
        });
        return;
    }
    // Show or hide the utterance wrap. Toggling display:none → '' restarts
    // the wrap's keyframe animation, which is what we want when the bubble
    // first appears at the start of typing.
    const wrap = laneEl.querySelector('[data-utterance-wrap]');
    if (wrap) {
        const showWrap = phase !== 'ask';
        const wasShown = wrap.style.display !== 'none';
        if (showWrap !== wasShown) {
            wrap.style.display = showWrap ? '' : 'none';
        }
    }
    const typedEl = laneEl.querySelector('[data-utterance]');
    if (typedEl) {
        typedEl.textContent = (step.utterance || '').slice(0, typedChars);
    }
    const caret = laneEl.querySelector('[data-caret]');
    if (caret) caret.style.display = phase === 'type' ? '' : 'none';
    const bubble = laneEl.querySelector('[data-bubble]');
    if (bubble) {
        const isDone = phase !== 'type' && phase !== 'ask';
        bubble.classList.toggle('is-done', isDone);
        bubble.classList.toggle('is-active', !isDone);
    }
    const translation = laneEl.querySelector('[data-translation]');
    if (translation) {
        const showTrans = phase !== 'type' && phase !== 'ask';
        translation.style.display = showTrans ? '' : 'none';
    }
}

// ----- Render: LLM lane (per llmGroup) -------------------------------------

function renderLlmLaneInner(journey, stepIdx, step, phase, extractIdx) {
    const isPolicyOnly = step.kind === 'policy-only';
    const callActive = !isPolicyOnly && (phase === 'extract' || phase === 'react' || phase === 'settle' || phase === 'done');
    const linesShown = phase === 'extract' ? extractIdx : step.patch ? step.patch.length : 0;
    const thinking = !isPolicyOnly && (phase === 'type' || phase === 'ask');

    const callBar = renderModelCallBar(callActive, thinking, isPolicyOnly, stepIdx + 1);
    const body = isPolicyOnly ? renderPolicyOnlyCard(phase) : renderJsonPatch(step, linesShown, phase);

    return `
        <span class="tj-active-stripe" data-stripe></span>
        ${callBar}
        ${body}
        <div class="tj-spacer"></div>
        <div class="tj-lane-footer">
            <span class="tj-lane-footer__left">
                <span class="tj-llm-footer-dot ${callActive ? 'is-on' : ''}" data-llm-foot-dot></span>
                Stateless · ein Aufruf, ein Patch
            </span>
            <span class="tj-lane-footer__right">Schema-validiert</span>
        </div>
    `;
}

function renderModelCallBar(callActive, thinking, skipped, n) {
    let label;
    let dotClass = '';
    if (skipped) {
        label = 'kein Modell-Call';
        dotClass = 'is-skipped';
    } else if (callActive) {
        label = 'Modell-Antwort #' + n;
        dotClass = 'is-active';
    } else if (thinking) {
        label = 'Aufruf wird gesendet…';
        dotClass = 'is-thinking';
    } else {
        label = 'wartet';
    }
    return `
        <div class="tj-call-bar" data-call-bar>
            <span class="tj-call-bar__left">
                <span class="tj-call-bar__dot ${dotClass}" data-call-dot></span>
                <span class="tj-call-bar__label" data-call-label>${escapeHtml(label)}</span>
            </span>
            <span class="tj-call-bar__right">input → JSON</span>
        </div>
    `;
}

function renderPolicyOnlyCard(phase) {
    const value = phase !== 'ask' ? '"guardian"' : '…';
    return `
        <div class="tj-policy-only">
            <span class="tj-policy-only__intro">Diese Frage wird deterministisch beantwortet. Das Modell wird nicht aufgerufen.</span>
            <div class="tj-policy-only__body">
                <span class="tj-policy-only__label">DIRECT-PATCH</span>
                <pre class="tj-policy-only__pre" data-policy-only-pre>{
  "patient_role": ${escapeHtml(value)}
}</pre>
            </div>
        </div>
    `;
}

function renderJsonPatch(step, linesShown, phase) {
    const patch = step.patch || [];
    const streaming = phase === 'extract';
    const lines = patch
        .map((entry, i) => {
            const visible = i < linesShown;
            const last = i === patch.length - 1;
            const evidence = entry.evidence
                ? `<span class="tj-json__evidence">← „${escapeHtml(entry.evidence)}"</span>`
                : '';
            return `
                <div class="tj-json__line ${visible ? 'is-visible' : ''}" data-json-line="${i}">
                    <span class="tj-json__key">"${escapeHtml(entry.key)}"</span><span class="tj-json__punct">: </span><span class="tj-json__val">${escapeHtml(entry.value)}</span><span class="tj-json__punct">${last ? '' : ','}</span>${evidence}
                </div>
            `;
        })
        .join('');
    return `
        <div class="tj-json ${streaming ? 'is-streaming' : ''}" data-json>
            <div class="tj-json__brace">{</div>
            <div class="tj-json__lines">${lines}</div>
            <div class="tj-json__brace">}</div>
        </div>
    `;
}

// Within-llmGroup mutations: JSON line visibility, streaming border,
// call-bar dot/label, policy-only direct-patch value reveal.
function updateLlmLaneInPlace(laneEl, step, phase, extractIdx, stepIdx) {
    const isPolicyOnly = step.kind === 'policy-only';
    if (isPolicyOnly) {
        const pre = laneEl.querySelector('[data-policy-only-pre]');
        if (pre) {
            const value = phase !== 'ask' ? '"guardian"' : '…';
            pre.textContent = `{\n  "patient_role": ${value}\n}`;
        }
        return;
    }

    // JSON streaming border
    const jsonEl = laneEl.querySelector('[data-json]');
    if (jsonEl) jsonEl.classList.toggle('is-streaming', phase === 'extract');

    // JSON line visibility
    const linesShown = phase === 'extract' ? extractIdx : step.patch ? step.patch.length : 0;
    laneEl.querySelectorAll('[data-json-line]').forEach((line) => {
        const i = Number(line.dataset.jsonLine);
        line.classList.toggle('is-visible', i < linesShown);
    });

    // Call bar
    const callActive = phase === 'extract' || phase === 'react' || phase === 'settle' || phase === 'done';
    const thinking = phase === 'type' || phase === 'ask';
    const dot = laneEl.querySelector('[data-call-dot]');
    const labelEl = laneEl.querySelector('[data-call-label]');
    if (dot) {
        dot.classList.toggle('is-active', callActive);
        dot.classList.toggle('is-thinking', !callActive && thinking);
        dot.classList.toggle('is-skipped', false);
    }
    if (labelEl) {
        labelEl.textContent = callActive
            ? 'Modell-Antwort #' + (stepIdx + 1)
            : thinking
              ? 'Aufruf wird gesendet…'
              : 'wartet';
    }
    const footDot = laneEl.querySelector('[data-llm-foot-dot]');
    if (footDot) footDot.classList.toggle('is-on', callActive);
}

// ----- Render: policy lane (per policyGroup) -------------------------------
//
// Two renders per step: 'pre' (no fresh fills, no flag, waiting next-step)
// and 'reacted' (post-swap schema, flag if any, slots in pre-react state so
// the staggered tick-on transitions can fire). Within 'reacted', slot ticks
// and next-step state are toggled imperatively.

function renderPolicyLaneInner(journey, stepIdx, step, group, phase) {
    const reacted = group === 'reacted';
    const stepsApplied = reacted ? stepIdx + 1 : stepIdx;
    const policy = composePolicyState(journey, stepsApplied);
    const schema = SCHEMAS[policy.schemaId];
    const justSwapped = reacted && !!step.schemaSwap;
    const freshKeys = step && step.patch ? step.patch.map((p) => p.key.split('.')[0]) : [];

    // Pre-react slot fills (excludes this step's contribution): used to mount
    // 'reacted' with the *old* fills on, fresh ones off, so the imperative
    // class flip after mount triggers staggered transitions.
    const preFilled = composePolicyState(journey, stepIdx).filled;

    return `
        <span class="tj-active-stripe" data-stripe></span>
        ${renderSchemaBar(schema, policy.role, policy.priority, justSwapped)}
        ${renderRedFlagPanel(policy.redFlag, reacted)}
        ${renderSlotTracker(schema, preFilled, freshKeys, reacted)}
        <div class="tj-spacer"></div>
        ${renderNextStep(policy.nextAsk, nextStepState(phase))}
    `;
}

function renderSchemaBar(schema, role, priority, swapped) {
    const elevated = priority === 'elevated';
    const roleLabel = role === 'guardian' ? 'Stellvertreter:in' : role === 'self' ? 'Patient:in selbst' : 'noch nicht festgelegt';
    return `
        <div class="tj-schema-bar ${swapped ? 'is-swapped' : ''}">
            <div class="tj-schema-bar__top">
                <span class="tj-schema-bar__label">Aktives Schema</span>
                <span class="tj-priority-chip ${elevated ? 'is-elevated' : ''}">
                    <span class="tj-priority-chip__dot"></span>
                    Priorität: ${elevated ? 'erhöht' : 'normal'}
                </span>
            </div>
            <div class="tj-schema-bar__row">
                <span class="tj-schema-bar__name">${escapeHtml(schema.label)}</span>
                ${swapped ? '<span class="tj-schema-bar__badge">hot-swap</span>' : ''}
            </div>
            <span class="tj-schema-bar__role">
                Rolle: <strong>${escapeHtml(roleLabel)}</strong>
            </span>
        </div>
    `;
}

function renderRedFlagPanel(flag, visible) {
    if (!flag || !visible) {
        return `
            <div class="tj-flag tj-flag--empty">
                <span class="tj-flag__dot"></span>
                Konstellations-Tabelle: keine Treffer.
            </div>
        `;
    }
    const parts = flag.parts.map((p) => `<span class="tj-flag__pill">${escapeHtml(p)}</span>`).join('');
    return `
        <div class="tj-flag tj-flag--hit">
            <div class="tj-flag__top">
                <span class="tj-flag__heading">Konstellation erkannt</span>
                <span class="tj-flag__id">flag: ${escapeHtml(flag.id)}</span>
            </div>
            <div class="tj-flag__pills">${parts}</div>
            <span class="tj-flag__disclaimer">Statischer, von der Praxis genehmigter Hinweis: „${escapeHtml(flag.disclaimer)}"</span>
            <span class="tj-flag__note">Keine Diagnose. Kein Triage-Urteil. Keine Modell-Aussage.</span>
        </div>
    `;
}

function renderSlotTracker(schema, preFilled, freshKeys, reacted) {
    const items = schema.required;
    // 'pre' group: only preFilled slots are on. 'reacted' group: preFilled
    // remain on; fresh slots start off and get toggled .is-on after mount
    // so transitions fire with their per-slot delays.
    const STAGGER_MS = 280;
    const BASE_MS = 120;

    const filledCount = items.filter((s) => preFilled.has(s.key) || (reacted && freshKeys.includes(s.key))).length;

    const rows = items
        .map((s) => {
            const isFresh = freshKeys.indexOf(s.key);
            const wasOn = preFilled.has(s.key);
            const willBeOn = wasOn || (reacted && isFresh >= 0);
            const delay = reacted && !wasOn && isFresh >= 0 ? BASE_MS + isFresh * STAGGER_MS : 0;
            const fresh = reacted && isFresh >= 0 && !wasOn;
            const styles = `transition-delay: ${delay}ms;`;
            const haloCls = fresh ? 'is-pulsing' : '';
            // Mount with .is-on only if pre-filled. Fresh ones get .is-on
            // imperatively after mount so the transition can run.
            const mountedOn = wasOn;
            return `
                <div class="tj-slot ${mountedOn ? 'is-on' : ''}"
                     data-slot-key="${escapeHtml(s.key)}"
                     data-slot-fresh="${fresh ? '1' : '0'}"
                     data-slot-target="${willBeOn ? '1' : '0'}"
                     style="${styles}">
                    <span class="tj-slot__box ${haloCls}" style="${styles}">
                        ${ICON_CHECK}
                    </span>
                    <span class="tj-slot__label" style="${styles}">${escapeHtml(s.de)}</span>
                </div>
            `;
        })
        .join('');

    return `
        <div class="tj-slots" data-slots>
            <div class="tj-slots__top">
                <span class="tj-slots__label">Pflicht-Slots</span>
                <span class="tnum tj-slots__count" data-slots-count>${filledCount}/${items.length}</span>
            </div>
            <div class="tj-slots__grid">${rows}</div>
        </div>
    `;
}

function renderNextStep(nextAsk, state) {
    const headLabel =
        state === 'ready'
            ? 'Nächste Frage — Policy hat gewählt'
            : state === 'pulsing'
              ? 'Policy wählt nächste Frage…'
              : 'Nächste Frage (wird nach Reaktion gewählt)';
    const body =
        state === 'ready'
            ? escapeHtml(nextAsk || '—')
            : state === 'pulsing'
              ? 'Pflicht-Slots werden geprüft, Konstellations-Tabelle läuft…'
              : '… wartet auf Slot-Patch und Konstellations-Prüfung';
    return `
        <div class="tj-next is-${state}" data-next data-next-state="${state}" data-next-ask="${escapeHtml(nextAsk || '')}">
            <span class="tj-next__head" data-next-head>
                ${state === 'pulsing' ? '<span class="tj-next__dot"></span>' : ''}
                ${escapeHtml(headLabel)}
            </span>
            <span class="tj-next__body" data-next-body>${body}</span>
        </div>
    `;
}

// After a 'reacted' mount, kick the fresh-slot tick-ons + total counter.
function fireFreshSlotTicks(laneEl) {
    const slots = laneEl.querySelectorAll('[data-slot-fresh="1"]');
    if (!slots.length) return;
    // Force reflow so the upcoming class change actually transitions.
    void laneEl.offsetWidth;
    slots.forEach((slot) => slot.classList.add('is-on'));
}

// Within 'reacted' phase group, just transition the next-step card between
// 'pulsing' (react) and 'ready' (settle/done). The card's keyframe animation
// fires once per state mount, which is exactly what the design wants.
function updateNextStepCard(laneEl, journey, stepIdx, phase) {
    const next = laneEl.querySelector('[data-next]');
    if (!next) return;
    const desired = nextStepState(phase);
    if (next.dataset.nextState === desired) return;
    const policy = composePolicyState(journey, stepIdx + 1);
    const ask = policy.nextAsk || '';
    next.outerHTML = renderNextStep(ask, desired);
}

// ----- Render: caption + transport -----------------------------------------

function renderCaption(journey, step, phase) {
    const visible = step && (phase === 'react' || phase === 'settle' || phase === 'done' || phase === 'extract');
    const text = visible ? step.caption : journey.intro;
    return `
        <div class="tj-caption ${visible ? 'is-visible' : ''}">
            <span class="tj-caption__label">WAS GERADE PASSIERT IST</span>
            <span class="tj-caption__text">${escapeHtml(text || '')}</span>
        </div>
    `;
}

function renderTransport(journey, stepIdx, phase, isPlaying) {
    const stepCount = journey.steps.length;
    return `
        <div class="tj-transport">
            <div class="tj-transport__buttons">
                <button class="tj-btn tj-btn--ink" data-action="play" type="button">
                    ${isPlaying ? ICON_PAUSE : ICON_PLAY}
                    ${isPlaying ? 'Pause' : 'Wiedergabe'}
                </button>
                <button class="tj-btn tj-btn--outline" data-action="replay" type="button">
                    ${ICON_REPLAY}
                    Wiederholen
                </button>
            </div>
            <div class="tj-transport__bar">
                <div class="tj-transport__fill" data-transport-fill></div>
            </div>
            <span class="tnum tj-transport__pos" data-transport-pos>
                Schritt ${Math.min(stepIdx + 1, stepCount)} / ${stepCount} · ${phaseLabel(phase)}
            </span>
        </div>
    `;
}

function updateTransportInPlace(transportEl, journey, stepIdx, phase, isPlaying) {
    const stepCount = journey.steps.length;
    const phaseProg = phaseFraction(phase);
    const totalProg = (stepIdx + phaseProg) / stepCount;
    const fill = transportEl.querySelector('[data-transport-fill]');
    if (fill) fill.style.width = Math.max(0, Math.min(1, totalProg)) * 100 + '%';
    const pos = transportEl.querySelector('[data-transport-pos]');
    if (pos) {
        pos.textContent = `Schritt ${Math.min(stepIdx + 1, stepCount)} / ${stepCount} · ${phaseLabel(phase)}`;
    }
    const playBtn = transportEl.querySelector('[data-action="play"]');
    if (playBtn) {
        playBtn.innerHTML = `${isPlaying ? ICON_PAUSE : ICON_PLAY} ${isPlaying ? 'Pause' : 'Wiedergabe'}`;
    }
}

// ----- Attach --------------------------------------------------------------

function attach(rootEl) {
    const tabsEl = rootEl.querySelector('[data-tj-tabs]');
    const stageEl = rootEl.querySelector('[data-tj-stage]');
    const captionWrap = rootEl.querySelector('[data-tj-caption]');
    const transportWrap = rootEl.querySelector('[data-tj-transport]');
    if (!tabsEl || !stageEl || !captionWrap || !transportWrap) return;

    const state = {
        jIdx: 0,
        isPlaying: true,
        stepIdx: 0,
        phase: 'ask',
        typedChars: 0,
        extractIdx: 0,
        restartTick: 0,
    };

    let timer = null;
    const cache = {};
    let stageMounted = false;

    function paint() {
        const journey = JOURNEYS[state.jIdx];
        const stepIdx = clamp(state.stepIdx, 0, journey.steps.length - 1);
        const step = journey.steps[stepIdx];
        const activeLane = laneForPhase(state.phase, step);

        // Tabs — only on journey switch / replay.
        const tabsKey = `${state.jIdx}|${state.restartTick}`;
        if (cache.tabs !== tabsKey) {
            tabsEl.innerHTML = renderTabs(state.jIdx);
            bindTabHandlers();
            cache.tabs = tabsKey;
        }

        // Stage skeleton — once.
        if (!stageMounted) {
            stageEl.innerHTML = renderStageSkeleton();
            stageMounted = true;
        }

        const stepKey = `${state.jIdx}|${state.restartTick}|${stepIdx}`;

        // Lane headers — once per step (the tags don't change), then class
        // toggle for active lane on every paint.
        if (cache.laneHeadersStep !== stepKey) {
            stageEl.querySelector('[data-tj-lane-headers]').innerHTML = renderLaneHeaders();
            cache.laneHeadersStep = stepKey;
        }

        // Patient lane.
        const pKey = `${stepKey}|${patientGroup(state.phase, step)}`;
        const patientLaneEl = stageEl.querySelector('[data-tj-patient]');
        if (cache.patient !== pKey) {
            patientLaneEl.innerHTML = renderPatientLaneInner(journey, stepIdx, step, state.phase, state.typedChars);
            cache.patient = pKey;
        } else {
            updatePatientLaneInPlace(patientLaneEl, step, state.phase, state.typedChars);
        }

        // LLM lane.
        const lKey = `${stepKey}|${llmGroup(state.phase, step)}`;
        const llmLaneEl = stageEl.querySelector('[data-tj-llm]');
        if (cache.llm !== lKey) {
            llmLaneEl.innerHTML = renderLlmLaneInner(journey, stepIdx, step, state.phase, state.extractIdx);
            cache.llm = lKey;
        } else {
            updateLlmLaneInPlace(llmLaneEl, step, state.phase, state.extractIdx, stepIdx);
        }

        // Policy lane.
        const qGroup = policyGroup(state.phase);
        const qKey = `${stepKey}|${qGroup}`;
        const policyLaneEl = stageEl.querySelector('[data-tj-policy]');
        if (cache.policy !== qKey) {
            policyLaneEl.innerHTML = renderPolicyLaneInner(journey, stepIdx, step, qGroup, state.phase);
            cache.policy = qKey;
            if (qGroup === 'reacted') {
                // Schedule the fresh-slot tick-ons after mount so transitions
                // run with their staggered per-slot delays.
                requestAnimationFrame(() => fireFreshSlotTicks(policyLaneEl));
            }
        }
        if (qGroup === 'reacted') {
            updateNextStepCard(policyLaneEl, journey, stepIdx, state.phase);
            // Update the slot count when fresh ticks fire (count was rendered
            // for the final post-react state; safe to leave alone).
        }

        // Active lane class on headers + lane wrappers + active stripes.
        applyActiveLane(stageEl, activeLane);

        // Caption — only on visibility-group transitions or step change.
        const cKey = `${stepKey}|${captionGroup(state.phase)}`;
        if (cache.caption !== cKey) {
            captionWrap.innerHTML = renderCaption(journey, step, state.phase);
            cache.caption = cKey;
        }

        // Transport — render once per step + isPlaying flip; update progress
        // bar + position label imperatively otherwise.
        const tShellKey = `${stepKey}|${state.isPlaying ? '1' : '0'}`;
        if (cache.transportShell !== tShellKey) {
            transportWrap.innerHTML = renderTransport(journey, stepIdx, state.phase, state.isPlaying);
            bindTransportHandlers();
            cache.transportShell = tShellKey;
        } else {
            updateTransportInPlace(transportWrap, journey, stepIdx, state.phase, state.isPlaying);
        }
    }

    function resetPaintCache() {
        cache.tabs = '';
        cache.laneHeadersStep = '';
        cache.patient = '';
        cache.llm = '';
        cache.policy = '';
        cache.caption = '';
        cache.transportShell = '';
    }

    function bindTabHandlers() {
        tabsEl.querySelectorAll('[data-tab-idx]').forEach((btn) => {
            btn.addEventListener('click', () => {
                const i = Number(btn.dataset.tabIdx);
                if (i === state.jIdx) return;
                state.jIdx = i;
                state.restartTick++;
                state.stepIdx = 0;
                state.phase = 'ask';
                state.typedChars = 0;
                state.extractIdx = 0;
                clearTimeout(timer);
                resetPaintCache();
                paint();
                if (state.isPlaying) tick();
            });
        });
    }

    function bindTransportHandlers() {
        const playBtn = transportWrap.querySelector('[data-action="play"]');
        const replayBtn = transportWrap.querySelector('[data-action="replay"]');
        if (playBtn) {
            playBtn.addEventListener('click', () => {
                state.isPlaying = !state.isPlaying;
                clearTimeout(timer);
                paint();
                if (state.isPlaying) tick();
            });
        }
        if (replayBtn) {
            replayBtn.addEventListener('click', () => {
                state.restartTick++;
                state.stepIdx = 0;
                state.phase = 'ask';
                state.typedChars = 0;
                state.extractIdx = 0;
                clearTimeout(timer);
                resetPaintCache();
                paint();
                if (state.isPlaying) tick();
            });
        }
    }

    function tick() {
        clearTimeout(timer);
        if (!state.isPlaying) return;

        const journey = JOURNEYS[state.jIdx];
        const stepIdx = clamp(state.stepIdx, 0, journey.steps.length - 1);
        const step = journey.steps[stepIdx];
        if (!step) return;

        if (state.phase === 'ask') {
            timer = setTimeout(() => {
                if (step.kind === 'policy-only') {
                    state.phase = 'react';
                } else {
                    state.typedChars = 0;
                    state.phase = 'type';
                }
                paint();
                tick();
            }, PHASE_DURATIONS.ask);
        } else if (state.phase === 'type') {
            const len = (step.utterance || '').length;
            if (state.typedChars < len) {
                timer = setTimeout(() => {
                    state.typedChars = Math.min(state.typedChars + 1, len);
                    paint();
                    tick();
                }, step.typeMs || 32);
            } else {
                timer = setTimeout(() => {
                    state.extractIdx = 0;
                    state.phase = 'extract';
                    paint();
                    tick();
                }, PHASE_DURATIONS.preExtract);
            }
        } else if (state.phase === 'extract') {
            const total = (step.patch || []).length;
            if (state.extractIdx < total) {
                timer = setTimeout(() => {
                    state.extractIdx++;
                    paint();
                    tick();
                }, PHASE_DURATIONS.extractStep);
            } else {
                timer = setTimeout(() => {
                    state.phase = 'react';
                    paint();
                    tick();
                }, PHASE_DURATIONS.postExtract);
            }
        } else if (state.phase === 'react') {
            timer = setTimeout(() => {
                state.phase = 'settle';
                paint();
                tick();
            }, PHASE_DURATIONS.react);
        } else if (state.phase === 'settle') {
            const isLastStep = state.stepIdx >= journey.steps.length - 1;
            timer = setTimeout(() => {
                if (isLastStep) {
                    state.phase = 'done';
                } else {
                    state.stepIdx++;
                    state.typedChars = 0;
                    state.extractIdx = 0;
                    state.phase = 'ask';
                }
                paint();
                tick();
            }, PHASE_DURATIONS.settle);
        } else if (state.phase === 'done') {
            timer = setTimeout(() => {
                state.jIdx = (state.jIdx + 1) % JOURNEYS.length;
                state.stepIdx = 0;
                state.phase = 'ask';
                state.typedChars = 0;
                state.extractIdx = 0;
                state.restartTick++;
                resetPaintCache();
                paint();
                tick();
            }, PHASE_DURATIONS.endHold);
        }
    }

    paint();
    tick();
}

export function init() {
    document.querySelectorAll('[data-three-journeys]').forEach(attach);
}