# Audania — Project Context

This Laravel application is the **Audania SaaS shell**: billing, Praxis admin, AVV management, the Praxis-facing UI (admin, billing, AVV, doctor inbox & Befund view), and the B2B marketing pages at `audania.de`.

## What Audania is

AI-native, conversational pre-visit medical intake for German Arztpraxen. Patients run the dialog in the waiting room (tablet) or on their phone via QR code; the doctor receives a structured anamnesis summary before the consultation.

Audania **collects information**; the doctor decides everything clinical. **No diagnosis, no triage, no therapy recommendation.** That is a non-negotiable product boundary, not a tagline — see `audania-hard-rules.md` for the code-level consequences.

## What this repo owns

- SaaS shell, billing, Praxis admin, AVV management.
- Praxis-facing UI (admin, billing, AVV, doctor inbox & Befund view) — Blade + Livewire.
- B2B marketing pages (`audania.de`) — dedicated Blade route group, own layout, no Livewire (parent monorepo `CLAUDE.md` §9, 2026-05-09 marketing-as-route-group decision).

## What this repo does NOT own

- **Patient-facing waiting-room flow** lives in the sibling repo `audania-patient-pwa` (Vue 3 PWA). Don't add patient-flow features here. If a feature has a "patient on tablet / phone" surface, that part belongs in the PWA, not in this app.
- **LLM dialog / slot-filling** lives in the sibling service `audania-dialog` (Python 3.12 + FastAPI). This app calls it over HTTP. No LLM SDK belongs in this `composer.json` — see `audania-stack.md`.
- **Slot definitions** (per Beschwerdebild) live in the parent Audania monorepo at `20-product/slot-definitions/`. They are spec, not code; `audania-dialog` consumes them. Do not fork them into a Laravel module here.
- **Infrastructure-as-code** (Hetzner / STACKIT / IONOS / OVH FRA) lives in the sibling repo `audania-infra`.

## Strategic and brand context lives in the parent monorepo

This audania-saas repo is its own git repo, but it sits locally inside a parent **Audania monorepo** that holds strategy, brand, compliance, and product specs. This repo is engineering only and intentionally does not import those artefacts. When a question goes beyond engineering — competitive positioning, brand voice, slot schemas, compliance gates — the canonical answers live there:

- `00-strategy/` — market analysis, competitive analysis, ICP, pricing.
- `10-brand/` — voice, naming rationale, visual identity, design-system specimen, fonts.
- `20-product/` — UX flows, slot definitions, dialog policies, German patient-facing copy.
- `40-compliance/` — DSFA, AVV template, sub-processor list, DPAs, pen tests, MDR assessments, incident response.

The binding project brief is the root `CLAUDE.md` in that monorepo. The hard rules and stack decisions in this repo's `.ai/guidelines/` cite that brief with section and date stamps. **If a rule here and the root brief disagree, the root wins** — flag the drift.

## What "good" looks like for a feature here

Every notable PR description should answer the seven questions from root `CLAUDE.md` §5. Four of them bite in this app:

1. Which differentiation axis does this reinforce? ("None" is a red flag.)
2. Does this push toward MDR Class IIa? Justify "no", don't just check it.
3. Where does the data live, who processes it, is the AVV / sub-processor list still accurate?
4. What is the build-in-public artefact? At minimum a one-line claim.

The remaining three (slot schema, eval method, performance budget) usually apply to `audania-dialog` or `audania-patient-pwa`, not to this app.
