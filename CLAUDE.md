# oursolve_theme — Claude Context

## What Is This
Custom WordPress theme for oursolve.com. Matches the design system of the static tools site.

- **GitHub:** https://github.com/mahfujars/oursolve_theme
- **Deploy target:** `/home/oursolve/public_html/wp-content/themes/oursolve/`
- **Theme slug:** `oursolve`

---

## Deploy Flow
Push to GitHub → cPanel Git Version Control → **Update from Remote** → **Deploy HEAD Commit**

`.cpanel.yml` copies all theme files to `wp-content/themes/oursolve/`.

**Git repo cloned to:** `/home/oursolve/oursolve_theme/` (not public_html)

---

## File Structure

```
oursolve_theme/
├── assets/
│   └── main.css          # Full design system CSS
├── style.css             # WP theme header (name/description only, no styles)
├── functions.php         # Enqueue assets, CORS, excerpt length
├── header.php            # DOCTYPE + head + nav
├── footer.php            # Footer + wp_footer()
├── front-page.php        # Homepage — fetches tools.json + WP REST API blog preview
├── home.php              # Blog listing (WP loop, PHP pagination)
├── single.php            # Single post — featured image, reading time, tags
├── page.php              # Static WP pages
├── index.php             # Minimal fallback
└── .cpanel.yml           # cPanel deploy config
```

---

## Design System

Matches `oursolve_tools` exactly:

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

---

## WP Settings Required

- **Settings → Reading:** Static page → Homepage: "Home" page, Posts page: "Blog" page
- **Appearance → Themes:** Activate "Oursolve"

---

## Tools JSON

`front-page.php` fetches `/tools/tools.json` (from `oursolve_tools` repo) to render the tools grid dynamically. No PHP changes needed to add a new tool — just update `tools.json`.
