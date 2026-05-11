# Audania — Operating Entity

## Legal entity vs. product brand

- **Legal entity / operator:** Mike Esser Trading & Consulting (Einzelunternehmen, sole proprietor: Mike Esser).
- **Product brand:** Audania.
- **There is no "Audania GmbH".** Audania is a product name, not a separate legal entity. Any code, copy, or document that names a legal counterparty must name **Mike Esser Trading & Consulting**, not "Audania" and not "Audania GmbH".

## Where this bites in code and copy

When generating any of the following, use the legal entity — not the product brand — as the named party:

- **Impressum / legal notice** on marketing pages (`audania.de`).
- **Datenschutzerklärung** — controller-of-the-website identity, contact for data-subject requests.
- **AVV (Auftragsverarbeitungsvertrag) template** — the processor side is Mike Esser Trading & Consulting; the Praxis is controller.
- **Invoices and Stripe-EU billing config** — seller name, tax IDs, address.
- **Email "From" name and signatures** for transactional and contract email.
- **Contracts, NDAs, sub-processor list entries.**

The product brand "Audania" is correct everywhere else: UI strings, marketing headlines, product copy, OG tags, app name.

## If the entity ever changes

If Mike Esser Trading & Consulting is later converted into a GmbH or another legal form, that is a hard-rule change for AVV / Impressum / billing and must be:

1. Logged as a dated decision in the parent monorepo's root `CLAUDE.md` §9.
2. Reflected here, in this file, in the same change.
3. Reflected in `40-compliance/` (AVV template, sub-processor list, DSFA) in the same change.

Until that happens, treat any reference to "Audania GmbH" in code, copy, or contracts as a bug.