# Audania — Hard Rules That Bite In Code

Distilled from the parent Audania monorepo's `CLAUDE.md` §2. These are non-negotiable. If a feature request runs against any of them, stop and ask before implementing. The root brief is canonical for tie-breaks.

## No diagnosis, no triage, no therapy recommendation

Audania collects information; the doctor decides. This rule applies everywhere in this codebase:

- No severity scoring; no "likely" / "wahrscheinlich" / probability columns.
- No triage-coloured UI states (red / amber / green urgency badges in the doctor inbox or anywhere else).
- No sorting of doctor-inbox entries by computed urgency.
- No summarisation that ranks differentials, suggests next steps, or warns the patient ("go to the ER", "this might be serious").
- Disclaimers in patient-facing pages must say so explicitly. Patient-facing surface in this repo is small (mostly marketing pages and the post-QR-scan landing), but the rule still holds.

This is the gate that keeps Audania out of MDR Class IIa. Treat any feature that flirts with it as stop-and-flag.

## DSGVO + EU residency for every dependency

Patient-entered data is health data (Art. 9 special category). Every external service in the data path must be EU-hosted or contractually confirmed to keep customer data on EU soil. Concrete code-level rules:

- **Billing:** Stripe-EU (Ireland) — not Stripe-US.
- **Errors / observability:** self-hosted Sentry, or an EU-only SaaS with documented residency. Never `sentry.io` with default region.
- **Email:** an EU mail provider with AVV (Mailjet EU, Postmark EU, similar). Never a US-only provider.
- **Fonts:** bundle from the parent monorepo's `10-brand/visual-identity/fonts/` and serve self-hosted. **Never** Google Fonts CDN — that is a US data path on every page load.
- **LLM inference:** not from this app at all (see `audania-stack.md`). When this app calls `audania-dialog`, that service handles its own EU-endpoint contract.
- **Frontend dependencies (npm):** evaluated for tracking SDKs; nothing that beacons home to a non-EU endpoint.

When you add a new dependency, the question is not "does it work?" — it is "does it preserve EU residency?" Document the answer in the PR description. The sub-processor list in the parent monorepo's `40-compliance/` is updated in the same change.

## No patient free-text in logs, ever

Logs are pseudonymised at write time, not at aggregation time. Concrete:

- Never `Log::info($request->all())` or any equivalent that dumps the full request body.
- Never log raw Eloquent attributes for tenant-scoped models without a redaction step. Use a `toLogArray()`-style helper that returns only safe identifiers (UUIDs, FK IDs, timestamps), never patient text or contact fields.
- Sentry breadcrumbs and exceptions: configure scrubbing of request bodies, headers, and Eloquent attributes before they leave the process. Disable local-variable inclusion in error reports — stack traces are fine, the variable values inside frames are not.
- Queue job payloads are logs too. If a job carries patient data, the payload must hold IDs that resolve through the DB, not the data itself.

Art. 9 health data in a log file is an Art. 33 incident. Treat it accordingly.

## Multi-tenancy is non-negotiable

Every tenant-scoped model has row-level isolation per Praxis. A missing global scope is a data leak under Art. 32 — not a UI bug.

- Use a `BelongsToPraxis` trait (or equivalent) that adds an Eloquent global scope on `praxis_id` to every tenant-scoped model.
- Tests are required for the scope: "scope filters cross-tenant rows" and "any `withoutGlobalScopes` usage is justified and audited" — the latter ensures bypass is intentional, not accidental.
- Migrations on tenant-scoped tables include `praxis_id` as a NOT NULL FK with a composite index, from the first migration. No retro-fitting.
- Praxis admins can reach only their own data. Never interpolate `praxis_id` from request input — derive it from the authenticated user / tenant context.

## No real patient data on this filesystem, ever

Per the parent monorepo's README "house rules". Seeders, factories, and demo fixtures are synthetic. If a customer ever sends a real export "to test", reject it — it must not land in this repo or its dev databases.

## Patient-facing copy in German (`Sie` default); everything else English

Code, comments, commit messages, ADRs, internal docs: English. Patient-facing copy: German, formal `Sie` default. The patient-facing surface in this repo is small (marketing pages, landing pages after a QR scan) — those are German with `Sie`. The `Du` toggle is a per-Praxis option for the **patient dialog flow** (which lives in `audania-patient-pwa`), not for marketing. Marketing always `Sie`.

## No production exposure to real patient data before §7 gate

The pre-launch checklist (root `CLAUDE.md` §7) must be fully checked off and dated in the parent monorepo's `40-compliance/` before any paying customer's patients touch this system.

If a PR introduces a route, queue, or scheduled job that would handle real patient data in production, link to the compliance gate status in the PR description. Until the gate is complete, the feature can ship behind a feature flag — but it must not run for a real Praxis with real patients.
