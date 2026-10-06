# EuropianUnion

Website of an EU co-funded project. This repository holds the **React reference version**: the structure,
design and behaviour are polished here first, then rebuilt as a WordPress theme for the final delivery.

Everything is a placeholder for now: the project name ("Atria"), the logo, all texts (lorem ipsum) and photos (Unsplash).

## Run

```bash
npm install
npm run dev      # local development
npm run build    # production build into dist/
npm run preview  # serve the build
```

## Deploy

Pushing to `main` builds and publishes to GitHub Pages (`.github/workflows/deploy.yml`).
In the repository settings set **Pages → Source → GitHub Actions**.
The base path is the `VITE_BASE` build variable: `/EuropianUnion/` on GitHub Pages, `/` on a custom domain.

## Structure

| Path | What it is | WordPress equivalent |
| --- | --- | --- |
| `src/data/site.ts` | site name, contacts, menus, announcement bar, EU disclaimer | theme options + nav menus |
| `src/data/content.ts` | news, events, Open Calls, partners, resources, team | post types and their fields |
| `src/pages/` | one file per page template | page / archive / single templates |
| `src/components/` | header, footer, cards, blocks | template parts and blocks |
| `src/styles/` | plain CSS: `tokens.css` (colours, type), `base.css`, `components.css`, `sections.css`; no rounded corners | moves into the theme as is |
| `public/img/` | placeholder photos (WebP) | media library |

Pages: Home, About, Open Calls (+ single call), Partners (+ single partner), News (+ single post),
Events (+ single event), Resources, Digital Platform, Contact, Privacy policy, Cookie policy, Accessibility statement.

To restyle the site when the visual identity arrives, change the values in `src/styles/tokens.css`
and replace the logo in `src/components/Brand.tsx`.
