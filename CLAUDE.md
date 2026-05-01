# oursolve_theme — Claude Context

## What Is This
Custom WordPress theme for oursolve.com. Matches design system of static tools site exactly.

- **Local:** `oursolve_theme/` (inside `/Users/mahfujarrahman/oursolve/`)
- **GitHub:** https://github.com/mahfujars/oursolve_theme
- **Deploy target:** `/home/oursolve/public_html/wp-content/themes/oursolve/`
- **Theme slug:** `oursolve`

---

## Deploy Flow

1. Edit files locally
2. `git push` to GitHub
3. cPanel → **Git Version Control** → oursolve_theme → **Update from Remote**
4. **Deploy HEAD Commit** → `.cpanel.yml` copies files to `wp-content/themes/oursolve/`

**Git repo cloned to on server:** `/home/oursolve/oursolve_theme/` (not inside `public_html/`)

### First-time cPanel Git Setup (new server / after re-clone)
1. cPanel → Git Version Control → **Create**
2. Clone URL: `https://github.com/mahfujars/oursolve_theme.git`
3. Repository path: `/home/oursolve/oursolve_theme`
4. Update from Remote → Deploy HEAD Commit
5. WP Admin → Appearance → Themes → Activate **Oursolve**

---

## File Structure

```
oursolve_theme/
├── assets/
│   └── main.css          # Full design system CSS (all vars, nav, hero, cards, blog, footer)
├── style.css             # WP theme header only (name/description) — no actual styles here
├── functions.php         # Enqueue assets, CORS for REST API, excerpt length 25 words
├── header.php            # DOCTYPE + head + wp_head() + nav (brand + Home/Tools/Blog links)
├── footer.php            # Footer + wp_footer()
├── front-page.php        # Homepage — fetches /tools/tools.json for tools grid + WP REST API blog preview
├── home.php              # Blog listing (WP PHP loop, paginate_links())
├── single.php            # Single post — featured image, reading time, tags
├── page.php              # Static WP pages
├── index.php             # Minimal fallback (required by WP)
└── .cpanel.yml           # cPanel deploy config
```

---

## Design System

Identical to `oursolve_tools`:

| Token | Value |
|-------|-------|
| Primary | `#6366f1` |
| Primary dark | `#4f46e5` |
| Primary light | `#e0e7ff` |
| Background | `#f8fafc` |
| Surface | `#ffffff` |
| Text | `#0f172a` |
| Text muted | `#64748b` |
| Border | `#e2e8f0` |
| Hero gradient | `linear-gradient(135deg, #1e1b4b, #312e81, #4338ca)` |
| Font | `-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif` |
| Card radius | `16px` |

All tokens are CSS vars in `assets/main.css`. Edit there — everything updates.

---

## WP Settings Required

- **Appearance → Themes:** Activate "Oursolve"
- **Settings → Reading:** Static page → Homepage: blank "Home" page, Posts page: blank "Blog" page

---

## Tools Grid (front-page.php)

Fetches `/tools/tools.json` (served by `oursolve_tools` deploy, lives at `public_html/tools/tools.json`) to render tools grid. No PHP edit needed to add a new tool — add entry to `tools.json` in `oursolve_tools` repo.

---

## Key Constraints

- Pure PHP + CSS only — no npm, no build tools, no JS frameworks
- No `Co-Authored-By` or trailer lines in commits
