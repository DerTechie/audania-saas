# Audania commit convention

> Engineering-side mirror of the changelog automation in the parent monorepo. See root `CLAUDE.md` §3 ("Changelog stays current") and §9 entries from 2026-05-13 for the *why*. This file is the *how* — what every commit in `audania-saas` must look like so the changelog auto-populates without manual curation.

---

## Format

Every commit body ends with a Conventional Commit subject **and** a block of `Changelog-*` trailers. The trailers are read by `scripts/changelog.py` (parent project, via the installed `post-commit` hook) and used to populate the corresponding `changelog.json` entry's fields directly — no curation pass afterwards.

```
<type>(<scope>): <subject>
                                       ← blank line
<body — what changed and why, free prose>

                                       ← blank line before trailers
Changelog-Effort: <duration>
Changelog-Public: true|false
Changelog-Tags: <tag1>, <tag2>, <tag3>
Changelog-Related-Project: <project-entry-id>
Co-Authored-By: Claude Opus 4.7 (1M context) <noreply@anthropic.com>
```

`type`/`scope` follow Conventional Commits (`feat`, `fix`, `refactor`, `docs`, `chore`, `style`, `perf`, `test`, `build`, `ci`, `revert`). The trailers below are read by the sync script.

---

## Required trailers

### `Changelog-Effort: <duration>`

How long the work took, in focused minutes. The Claude Code session length is the best proxy — wall-clock between starting the task and the commit, minus obvious idle gaps.

Format accepted by the parser (`scripts/changelog.py::parse_duration`):

- `45m` — minutes only
- `1h` — whole hours
- `1h30m` or `1h 30m` — combined
- `1.5h` — decimal hours
- `90` — plain integer assumes minutes

Sets the entry's `effort_minutes` (integer) and `effort_source: "tracked"`.

### `Changelog-Public: true|false`

Whether this commit, as written, is eligible for build-in-public re-use (blog, LinkedIn, talk slide, whitepaper excerpt). Default conservative: **false**. Flip to `true` only when:

- The work is *category knowledge* — visible product surfaces, architectural patterns explained at the level a peer would expect on a blog, plain-text deliverables, design decisions, public-facing legal text (Impressum, Datenschutz).
- It does **not** leak *execution IP* — full slot schemata, eval test-sets, exact prompt strings, sub-processor names with concrete account relationships, internal evaluator scores. See the IP-leakage feedback memory referenced in root `MEMORY.md`.

When in doubt: `false`. The user (Mike) can flip later. Reverting a public claim is awkward; setting `public: true` post-fact is one-line.

Sets the entry's `public` boolean.

---

## Optional trailers

### `Changelog-Tags: <tag1>, <tag2>, <tag3>`

Domain tags beyond the CC scope. The CC scope (e.g., `marketing` in `feat(marketing): …`) becomes a tag automatically; this trailer adds more. Comma-separated, free-form lowercase, kebab-case.

Examples: `claude-design`, `copy`, `praxis-register`, `legal`, `dsgvo`, `impressum`, `tailwind-v4`, `self-hosted-fonts`, `slot-fill`, `patient-journeys`.

Aim for 2–4 tags. They drive the search/filter chips in `changelog.html`; too many tags = no signal.

### `Changelog-Related-Project: <project-entry-id>`

If the commit *implements* a decision recorded as a project-level changelog entry (root `changelog.json`), point at that entry by its `id`. The script reads this trailer and **also** writes the commit hash into the project entry's `related[]` array — so the cross-link is bidirectional after the next sync.

Project entry ids use the convention `YYYY-MM-DD-slug` (e.g., `2026-05-13-first-cd-brief-marketing`, `2026-05-11-operating-entity-defined`). Find them by scrolling root `changelog.json` or filtering `changelog.html` by Source=Project.

Omit the trailer entirely when the commit isn't tied to a specific project entry (most fix/refactor commits, internal plumbing, etc.).

---

## Title and summary — what the script does automatically

The entry's `title` is the CC subject line as-is. The `summary` is the first paragraph of the commit body, with all trailer lines (`Co-Authored-By:`, `Changelog-*:`, etc.) stripped. Both are read once on first sync and then preserved across subsequent syncs (per the script's merge-preservation contract — root `CLAUDE.md` §9 from 2026-05-13).

So: **write the commit body as if it were the changelog summary already**. First paragraph = the prose that should appear under the entry title in the timeline. Subsequent paragraphs (architectural justification, re-decision triggers, footnotes) are kept in git but won't render in the changelog.

---

## Examples

### Feature implementation linked to a project decision

```
feat(marketing): rewrite copy in Praxis-Register, drop verbots-vocab

Implements the Claude Design copy iteration (2026-05-13 CD-Brief). All
Praxis-facing surfaces switch PVS → Praxissoftware, Slot-Sets →
Anamnese-Bereiche, Sub-Auftragsverarbeiter → Dienstleister mit
Datenzugriff. KI-native / Booking-Lock-in / Funnel-Eingang /
Datenresidenz / MDR-by-design / Health-Fintech removed from
Praxis-facing copy. 13 files touched across hero, how, anatomy,
compliance, vs, cta, footer, journeys.

Changelog-Effort: 2h
Changelog-Public: true
Changelog-Tags: claude-design, copy, praxis-register
Changelog-Related-Project: 2026-05-13-first-cd-brief-marketing
Co-Authored-By: Claude Opus 4.7 (1M context) <noreply@anthropic.com>
```

### Internal fix with no project linkage

```
fix: serve self-hosted fonts via Vite asset pipeline

laravel-vite-plugin sets publicDir:false on the dev server, so the
@font-face files in /public/fonts/ were unreachable from
audania-saas.test:5173 — the browser silently fell back to system
fonts on every page in dev mode. Move the .ttf files into
resources/fonts/ and use relative URLs in @font-face so Vite serves
them in dev and emits fingerprinted copies under /build/assets/ in
prod. DSGVO posture unchanged: fonts remain self-hosted.

Changelog-Effort: 30m
Changelog-Public: false
Changelog-Tags: vite, asset-pipeline, dsgvo
Co-Authored-By: Claude Opus 4.7 (1M context) <noreply@anthropic.com>
```

### Engineering-side mirror of a project decision

```
docs(ai): pin operating entity as Mike Esser Trading & Consulting

Captures the brand-vs-legal-entity split so Impressum, Datenschutz,
AVV template, Stripe-EU billing, sub-processor list, and contract /
email "From" lines all name the legal entity. Product brand "Audania"
stays correct in UI strings.

See parent monorepo CLAUDE.md §9 (2026-05-11 entry) for the
canonical decision; this file is the engineering-side mirror per the
Boost extension model.

Changelog-Effort: 20m
Changelog-Public: false
Changelog-Tags: ai-guidelines, entity, boost
Changelog-Related-Project: 2026-05-11-operating-entity-defined
Co-Authored-By: Claude Opus 4.7 (1M context) <noreply@anthropic.com>
```

---

## When you forget a trailer

The script falls back to conservative defaults:

- No `Changelog-Effort` → `effort_minutes: null`, `effort_source: "unknown"` (entry needs manual fill-in later).
- No `Changelog-Public` → `public: false` (safe default; Mike can flip).
- No `Changelog-Tags` → only the CC scope ends up as a tag.
- No `Changelog-Related-Project` → no cross-link (omit unless there's a real project entry to point at).

The hook will still sync the commit — you just lose the auto-population for the absent trailers. **Better to commit with no trailer than to invent values.** A genuinely tracked 45m beats a made-up 2h.

---

## Re-decision triggers

Revisit this convention when any of these become true:

- A second Claude (or human contributor) starts authoring commits and the "Claude Code knows its own session length" assumption breaks. → Add a stricter linter / pre-commit hook that requires the trailers.
- Mike adopts an external time-tracker (Toggl, Harvest) as the source of truth. → Add a `Changelog-Effort-Source: timer` trailer or pull from the tracker's API.
- The CD-Brief workflow grows a third deliverable type and `Changelog-Related-Project` no longer feels expressive enough. → Add a `Changelog-Related-Brief` or similar trailer.
