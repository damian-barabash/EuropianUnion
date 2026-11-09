# TransBioNet — WordPress

The live site (transbionet.eu, Hostinger) runs this theme. The React app in the repo root is the design prototype.

- `transbionet/` — the theme. Pages are built from sections (ACF flexible content), fields are defined in `inc/fields.php`.
- `seed/seed.php` — first content moved from the prototype (`wp eval-file`); safe to re-run.
- `seed/guide.php` — private page "How to edit the site" (the team guide).
- `deploy.sh` — upload the theme, lint PHP, purge cache.

Plugins: ACF PRO (Secure Custom Fields until the licence arrives — same data), Yoast SEO, LiteSpeed Cache, UpdraftPlus, Wordfence.
The contact form, inbox ("Enquiries"), cookie banner and Google Tag Manager are part of the theme (no extra plugins).
Database dumps on the server: `~/bin/dbdump.sh <label>` → `~/backups/`.
