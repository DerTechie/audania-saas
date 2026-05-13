/**
 * Audania hero slot-filling demo. Drives the conversation cycle inside the
 * tablet mock: typing → saved → next slot → Befund payoff → reset.
 *
 * Auto-attaches to any element with `[data-slot-machine]`. Looks up child
 * regions by data-attribute so the markup stays declarative.
 */

const SLOTS = [
    {
        section: 'Anliegen',
        question: 'Was führt Sie heute zu uns?',
        kind: 'freetext',
        answer: 'Rückenschmerzen, vor allem nach längerem Sitzen.',
        typeMs: 32,
    },
    {
        section: 'Verlauf',
        question: 'Seit wann bestehen die Beschwerden?',
        kind: 'freetext',
        answer: 'Seit etwa drei Tagen.',
        typeMs: 42,
    },
    {
        section: 'Charakter',
        question: 'Wie würden Sie die Schmerzen am ehesten beschreiben?',
        kind: 'options',
        options: ['Ziehend, dumpf', 'Stechend, scharf', 'Brennend', 'Pulsierend'],
        answer: 'Ziehend, dumpf',
    },
    {
        section: 'Intensität',
        question: 'Wie stark sind die Schmerzen gerade?',
        kind: 'scale',
        answer: 6,
    },
];

const ARROW_NEXT = `<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>`;
const CHECK_MARK = `<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>`;

function escapeHtml(value) {
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

function renderSlotView(slot, slotIdx, total, state) {
    const dots = Array.from({ length: total }, (_, i) => {
        const done = i < slotIdx || (i === slotIdx && state.phase === 'saved');
        const now = i === slotIdx && state.phase !== 'saved';
        const cls = done ? 'is-done' : now ? 'is-now' : 'is-pending';
        return `<span class="slot-dot ${cls}"></span>`;
    }).join('');

    let answerSurface = '';
    if (slot.kind === 'freetext') {
        const caret =
            state.phase === 'typing'
                ? '<span class="slot-caret" aria-hidden="true"></span>'
                : '';
        const underline =
            state.phase === 'saved' ? '<div class="slot-underline"></div>' : '';
        const borderClass =
            state.phase === 'saved' ? 'is-saved' : 'is-active';
        answerSurface = `
            <div class="slot-freetext ${borderClass}">
                <span data-slot-typed>${escapeHtml(state.typed || '')}</span>${caret}${underline}
            </div>
        `;
    } else if (slot.kind === 'options') {
        answerSurface = `
            <div class="slot-options">
                ${slot.options
                    .map((opt) => {
                        const selected = state.typed === opt;
                        return `
                            <div class="slot-option ${selected ? 'is-selected' : ''}">
                                <span class="slot-radio"></span>
                                ${escapeHtml(opt)}
                            </div>
                        `;
                    })
                    .join('')}
            </div>
        `;
    } else if (slot.kind === 'scale') {
        const tiles = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
            .map((n) => {
                const selected = state.scaleVal === n;
                const reached = state.scaleVal !== null && n <= state.scaleVal;
                let cls = 'slot-scale-tile';
                if (selected) cls += ' is-selected';
                else if (reached) cls += ' is-reached';
                return `<div class="${cls}">${n}</div>`;
            })
            .join('');
        answerSurface = `
            <div>
                <div class="slot-scale">${tiles}</div>
                <div class="slot-scale-legend">
                    <span class="caption">kein Schmerz</span>
                    <span class="caption">stärkster vorstellbarer</span>
                </div>
            </div>
        `;
    }

    const ctaBtnClass =
        state.phase === 'saved' ? 'slot-cta-button is-saved' : 'slot-cta-button';
    const ctaIcon = state.phase === 'saved' ? CHECK_MARK : ARROW_NEXT;
    const ctaLabel = state.phase === 'saved' ? 'Gespeichert' : 'Weiter';

    return `
        <div class="slot-progress">
            <div class="slot-dots">${dots}</div>
            <span class="slot-meta">Frage ${slotIdx + 1} von ${total} · ${escapeHtml(slot.section)}</span>
        </div>
        <p class="prompt slot-question" key="${slotIdx}">${escapeHtml(slot.question)}</p>
        ${answerSurface}
        <div class="slot-spacer"></div>
        <div class="slot-cta">
            <span class="slot-cta-meta">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                Ende-zu-Ende verschlüsselt
            </span>
            <span class="${ctaBtnClass}">
                ${ctaLabel}${ctaIcon}
            </span>
        </div>
    `;
}

function renderBefund() {
    return `
        <div class="befund">
            <div class="befund-header">
                <span class="eyebrow" style="color: var(--color-clay);">ANAMNESE-BEFUND</span>
                <span class="befund-rule"></span>
                <span class="mono befund-id">PATIENT:IN NICHT IDENTIFIZIERT · 4F-21</span>
            </div>
            <h3 class="befund-title">Strukturierter Befund — bereit für die Übergabe.</h3>
            <div class="befund-rows">
                <div class="befund-label">Anliegen</div>
                <div class="befund-value is-quote">„Rückenschmerzen, vor allem nach längerem Sitzen.“</div>
                <div class="befund-label">Verlauf</div>
                <div class="befund-value is-quote">„Seit etwa drei Tagen.“</div>
                <div class="befund-label">Charakter</div>
                <div class="befund-value">Ziehend, dumpf</div>
                <div class="befund-label">Intensität</div>
                <div class="befund-value tnum">6 / 10</div>
            </div>
            <div class="befund-footer">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--color-note-ink)" stroke-width="2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                Der Befund liegt in Ihrer Praxissoftware, bevor die Patient:in ins Sprechzimmer kommt.
            </div>
        </div>
    `;
}

function renderRibbon(showBefund) {
    return `
        <span class="ribbon-status">
            <span class="ribbon-dot"></span>
            ${showBefund ? 'Befund an Ihre Praxissoftware übergeben' : 'Automatisch gespeichert · EU-Hosting'}
        </span>
        <span class="ribbon-aside">Keine Diagnose.</span>
    `;
}

function attach(root) {
    const body = root.querySelector('[data-slot-body]');
    const ribbon = root.querySelector('[data-slot-ribbon]');
    if (!body || !ribbon) return;

    const state = {
        slotIdx: 0,
        phase: 'typing',
        typed: '',
        scaleVal: null,
    };

    let timer = null;
    let lastFrameKey = '';
    const total = SLOTS.length;

    /**
     * Two-tier update: a "frame" (slot index + phase) drives a full re-render
     * — that's where the prompt's fade-up animation should fire and the caret
     * should mount fresh. Within a frame, typing/scale/option changes only
     * mutate the inner text or class list, so the surrounding chrome doesn't
     * blink on every keystroke.
     */
    function paint() {
        const frameKey = `${state.slotIdx}|${state.phase}`;
        const frameChanged = frameKey !== lastFrameKey;

        if (state.phase === 'befund') {
            if (frameChanged) {
                body.innerHTML = renderBefund();
                ribbon.innerHTML = renderRibbon(true);
                lastFrameKey = frameKey;
            }
            return;
        }

        if (frameChanged) {
            body.innerHTML = renderSlotView(SLOTS[state.slotIdx], state.slotIdx, total, state);
            ribbon.innerHTML = renderRibbon(false);
            lastFrameKey = frameKey;
            return;
        }

        const slot = SLOTS[state.slotIdx];
        if (slot.kind === 'freetext') {
            const typedEl = body.querySelector('[data-slot-typed]');
            if (typedEl) typedEl.textContent = state.typed || '';
        } else if (slot.kind === 'options') {
            body.querySelectorAll('.slot-option').forEach((el, i) => {
                el.classList.toggle('is-selected', state.typed === slot.options[i]);
            });
        } else if (slot.kind === 'scale') {
            body.querySelectorAll('.slot-scale-tile').forEach((tile, n) => {
                tile.classList.remove('is-selected', 'is-reached');
                if (state.scaleVal === n) tile.classList.add('is-selected');
                else if (state.scaleVal !== null && n <= state.scaleVal) tile.classList.add('is-reached');
            });
        }
    }

    function step() {
        clearTimeout(timer);

        if (state.phase === 'befund') {
            paint();
            timer = setTimeout(() => {
                state.slotIdx = 0;
                state.phase = 'typing';
                state.typed = '';
                state.scaleVal = null;
                step();
            }, 5200);
            return;
        }

        const slot = SLOTS[state.slotIdx];

        if (state.phase === 'typing') {
            state.typed = '';
            state.scaleVal = null;
            paint();

            if (slot.kind === 'freetext') {
                let i = 0;
                const tick = () => {
                    i += 1;
                    state.typed = slot.answer.slice(0, i);
                    paint();
                    if (i < slot.answer.length) {
                        timer = setTimeout(tick, slot.typeMs);
                    } else {
                        timer = setTimeout(() => {
                            state.phase = 'saved';
                            step();
                        }, 700);
                    }
                };
                timer = setTimeout(tick, 1100);
            } else if (slot.kind === 'options') {
                timer = setTimeout(() => {
                    state.typed = slot.answer;
                    paint();
                    timer = setTimeout(() => {
                        state.phase = 'saved';
                        step();
                    }, 800);
                }, 1400);
            } else if (slot.kind === 'scale') {
                let v = 0;
                const target = slot.answer;
                const tick = () => {
                    v += 1;
                    state.scaleVal = v;
                    paint();
                    if (v < target) timer = setTimeout(tick, 90);
                    else
                        timer = setTimeout(() => {
                            state.phase = 'saved';
                            step();
                        }, 800);
                };
                timer = setTimeout(tick, 1100);
            }
            return;
        }

        if (state.phase === 'saved') {
            paint();
            timer = setTimeout(() => {
                if (state.slotIdx < SLOTS.length - 1) {
                    state.slotIdx += 1;
                    state.phase = 'typing';
                } else {
                    state.phase = 'befund';
                }
                step();
            }, 1100);
            return;
        }
    }

    step();
}

export function init() {
    document.querySelectorAll('[data-slot-machine]').forEach(attach);
}