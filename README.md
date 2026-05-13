# audania-saas

The **Audania SaaS shell**: billing, Praxis admin, AVV management, the Praxis-facing UI (admin, billing, AVV, doctor inbox & Befund view), and the B2B marketing pages at `audania.de`. Laravel 13 / PHP 8.4, Blade + Livewire, MySQL 8.x, EU-hosted (Hetzner Cloud FRA / Nuremberg).

> Audania is an AI-native, conversational pre-visit medical intake assistant for German Arztpraxen. Patients run it on a waiting-room tablet or — via QR code — their own phone; the doctor receives a structured anamnesis summary before the consultation. Audania **collects information**; the doctor decides everything clinical. **No diagnosis, no triage, no therapy recommendation.** That boundary keeps the product out of MDR Class IIa and is treated as both ethics and moat.

## What this repo owns vs. what it doesn't

This repo is **only** the SaaS shell + Praxis-facing UI + marketing pages. Sibling repos (planned, currently not yet present under `30-code/`) carry:

- `audania-patient-pwa/` — Vue 3 PWA, patient-facing waiting-room flow (separate constraints: 5-year-old tablet over LTE, TTI < 3 s p95).
- `audania-dialog/` — Python 3.12 + FastAPI dialog/LLM microservice. **No LLM SDK belongs in this Laravel app**; calls go over HTTP to that service.
- `audania-infra/` — IaC for Hetzner Cloud / STACKIT / IONOS / OVH FRA.

Slot definitions (per Beschwerdebild) live in the parent monorepo at `20-product/slot-definitions/` as spec, not code — `audania-dialog/` consumes them.

## Where the canonical context lives

This repo is its own git repo and does **not** auto-load the parent monorepo's `CLAUDE.md`. The on-repo carrier of the load-bearing rules is `.ai/guidelines/audania-*.md` — Boost-merged into the generated `CLAUDE.md`, `AGENTS.md`, etc. on every `php artisan boost:install` / `boost:update`. Those generated files are git-ignored; **do not edit them — your edits will be overwritten**.

Active guideline files (Stand 2026-05-13):

- `audania-context.md` — what this repo owns vs. sibling repos.
- `audania-hard-rules.md` — code-level consequences of `CLAUDE.md` §2 (DSGVO/EU-residency, tenant isolation, no patient free-text in logs, …).
- `audania-stack.md` — Laravel 13 / Livewire / MySQL / Hetzner-FRA decisions + the "no LLM SDK in this repo" boundary.
- `audania-company.md` — operating-entity / brand split (Mike Esser Trading & Consulting vs. "Audania").
- `audania-commits.md` — `Changelog-*` commit-trailer convention.

When you need anything beyond engineering — competitive positioning, brand voice, slot schemas, compliance gates — the canonical answers live in the parent Audania monorepo (`00-strategy/`, `10-brand/`, `20-product/`, `40-compliance/`, `50-go-to-market/`). The root `CLAUDE.md` is the binding project brief; **if a rule here and the root brief disagree, the root wins — flag the drift.**

## Three hard rules worth surfacing here

Distilled from `audania-hard-rules.md`; the full list lives there.

1. **No diagnosis, no triage, no therapy recommendation.** No severity scoring, no urgency badges, no sort-by-urgency in the doctor inbox, no AI-summary prose. Audania records what the patient said; the doctor decides.
2. **Multi-tenancy is application-layer only.** Every tenant-scoped Eloquent model carries a `BelongsToPraxis` global scope on `praxis_id`. Tests for cross-tenant filtering and audited `withoutGlobalScopes` usage are the **only** enforcement gate (MySQL has no native RLS) — treat a failure or skip as a §2 hard-rule violation, not a flake.
3. **Pseudonymise at write time, not at aggregation time.** No patient free-text in logs, Sentry breadcrumbs, or queue payloads. Helpers like `toLogArray()` return only IDs + timestamps.

## Marketing pages live in this app

`audania.de` is a Blade route group inside this Laravel app — own layout, no Livewire, same deploy / AVV chain / Hetzner FRA host as the SaaS shell. Re-split triggers (CMS adoption, attack-surface escalation, separate marketing function) are documented in ADR `00-strategy/decisions/2026-05-09-marketing-as-route-group.md` in the parent monorepo.

## Getting started

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate

npm install
npm run dev
```

Laravel Boost is required for the AI-tooling workflow (generated CLAUDE.md / AGENTS.md). If you cloned fresh:

```bash
php artisan boost:install
```

This regenerates the agent-context files from the current `.ai/guidelines/` content + Laravel codebase introspection. Run again after editing any guideline file.

## Changelog & commit convention

This repo emits `Changelog-*` trailers in every commit body (`Changelog-Effort`, `Changelog-Public`, `Changelog-Tags`, `Changelog-Related-Project`). A post-commit hook at `.git/hooks/post-commit` calls the parent monorepo's `scripts/changelog.py`, which syncs this repo's `changelog.json` from git log and re-renders the parent's `changelog.html`. The merge-preservation contract: curated fields on existing entries survive every re-run.

Full convention + worked examples: `.ai/guidelines/audania-commits.md`.

If you cloned fresh and need to re-install the hook (hooks aren't versioned with the repo):

```bash
cat > .git/hooks/post-commit <<'EOF'
#!/bin/sh
set -e
REPO_ROOT="$(git rev-parse --show-toplevel)"
PROJECT_ROOT="$(cd "$REPO_ROOT/../.." && pwd)"
SCRIPT="$PROJECT_ROOT/scripts/changelog.py"
[ -f "$SCRIPT" ] || exit 0
python3 "$SCRIPT" --repo "$REPO_ROOT"
EOF
chmod +x .git/hooks/post-commit
```

## Testing

```bash
php artisan test
```

Pest is the test runner. The cross-tenant filtering tests in `tests/Feature/MultiTenancy/` (or equivalent) are load-bearing per the hard rule — treat their failure as a security incident, not a flake.

## License & operator

This repo is **proprietary**. Audania is operated by **Mike Esser Trading & Consulting** (Einzelunternehmen). There is no "Audania GmbH". Any code, copy, or document that names a legal counterparty must name the operating entity, not the product brand — see ADR `00-strategy/decisions/2026-05-11-operating-entity.md` in the parent monorepo for where this binds in code (Impressum, AVV, Stripe-EU billing, sub-processor list).

The Laravel framework itself is MIT-licensed; see `vendor/laravel/framework/LICENSE.md`.
