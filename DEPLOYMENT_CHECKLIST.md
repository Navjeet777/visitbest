# Visit-Best Deployment Checklist

**Site:** [visitbest.in](https://visitbest.in)  
**Host:** GoViral shared hosting (cPanel / LiteSpeed)  
**Repository:** [github.com/Navjeet777/visitbest](https://github.com/Navjeet777/visitbest)  
**Child theme:** `generatepress-child` (Visitbest v2.0.0)  
**Status:** Pre-deployment — **do not deploy until this checklist is approved**

---

## Pre-Deployment Verification Summary (2026-07-08)

| Check | Result | Notes |
|-------|--------|-------|
| 1. GitHub commits | **PASS** | Local `HEAD` = `origin/main` = `a80acb3` |
| 2. Child theme file inventory | **PASS** | 62 files in `generatepress-child/` |
| 3. PHP fatal errors | **PASS (after fix)** | Corrupted `class-performance.php` repaired — must be committed before deploy |
| 4. Duplicate functions/classes | **PASS** | 12 unique classes, no global function collisions |
| 5. Template parts loading | **PASS** | All `get_template_part()` paths resolve to existing files |
| 6. Missing assets | **PASS** | All enqueued CSS/JS files exist on disk |
| 7. Theme activation safety | **PASS** | Parent `generatepress` present; `Template: generatepress` set; hooks are additive |
| 8. Runtime PHP lint | **SKIPPED** | PHP CLI not available locally — run on server after upload |

### GitHub Commits (all on `main`)

| Hash | Message |
|------|---------|
| `a80acb3` | perf: production optimization and final QA |
| `b37f892` | feat: premium archive and search templates |
| `30b79ab` | feat: premium single article template |
| `122c467` | fix: stabilize homepage header and accessibility |
| `297ffc2` | Phase 2B: Homepage, premium header, and footer layout |
| `368c1f5` | Phase 2A: GeneratePress child theme foundation and design system |
| `535fa57` | Initial commit: WordPress 7.0 site |

Verify on GitHub: `git ls-remote origin main` should return `a80acb3…`

> **Action required before deploy:** Commit the `class-performance.php` syntax fix (parse error would white-screen the site on activation).

---

## Files to Upload

Upload the **entire child theme folder** to the server:

```
wp-content/themes/generatepress-child/
```

### Required files (complete inventory)

```
generatepress-child/
├── style.css                          ← required (theme header)
├── functions.php                      ← bootstrap
├── theme.json
├── front-page.php
├── content-single.php
├── archive.php
├── search.php
├── 404.php
├── index.php
├── searchform.php
├── assets/
│   ├── css/
│   │   ├── components/components.css
│   │   ├── design-system/             ← 6 files (tokens, typography, spacing, shadows, buttons, forms)
│   │   ├── editor.css
│   │   ├── layout/                    ← header, footer, homepage, single, archive
│   │   └── templates/earphones.css
│   └── js/
│       ├── header.js
│       └── earphones.js
├── inc/
│   ├── class-archive.php
│   ├── class-assets.php
│   ├── class-components.php
│   ├── class-header.php
│   ├── class-homepage.php
│   ├── class-layout.php
│   ├── class-performance.php
│   ├── class-single.php
│   ├── class-theme-setup.php
│   ├── integrations/generateblocks.php
│   ├── patterns/register-patterns.php
│   └── templates/earphones.php
├── template-parts/
│   ├── archive/                       ← archive-header.php, content-none.php
│   ├── components/                    ← 10 component files
│   ├── homepage/                      ← 5 section files
│   ├── layout/                        ← header.php, footer.php
│   └── single/                        ← article-header.php, sidebar.php
└── templates/page-earphones.php
```

### Optional (safe to upload, not required for production)

| File | Purpose |
|------|---------|
| `preview/homepage-preview.html` | Static visual reference only |
| `AUDIT.md` | Internal documentation |

### Parent theme (must already exist on server — do not overwrite)

```
wp-content/themes/generatepress/       ← stock GeneratePress parent
```

---

## Files That Must NOT Be Uploaded

| Path | Reason |
|------|--------|
| `wp-config.php` | Contains database credentials unique to each environment |
| `.env` / `.env.*` | Secrets |
| `wp-content/uploads/` | User media — sync separately, never overwrite production uploads |
| `wp-content/cache/` | Regenerated at runtime |
| `wp-content/ai1wm-backups/` | Large backup archives |
| `wp-content/debug.log` | Local log file |
| `error_log` | Server log |
| `.git/` | Not needed on shared hosting |
| `node_modules/` | Not used by this theme |
| `*.sql` / `*.zip` / `*.wpress` | Backup archives |

---

## Backup Steps (Before Any Deployment)

### 1. Hosting backup (cPanel)

- [ ] Log in to GoViral cPanel
- [ ] Open **Backup** or **Backup Wizard**
- [ ] Download a **full account backup** OR at minimum:
  - [ ] Home directory (`public_html/visitbest.in/`)
  - [ ] MySQL database for the site

### 2. WordPress backup (alternative)

- [ ] WP Admin → **All-in-One WP Migration** → Export
- [ ] Save `.wpress` file locally with date stamp (e.g. `visitbest-pre-deploy-2026-07-08.wpress`)

### 3. Git snapshot

- [ ] Confirm GitHub `main` is at `a80acb3` (or later with performance fix)
- [ ] Note current active theme name in WP Admin → Appearance → Themes

### 4. Database export (manual)

```bash
# Via cPanel phpMyAdmin: Export → Quick → SQL
# Save as: visitbest-db-backup-YYYY-MM-DD.sql
```

---

## Database Changes Required

**None.** This deployment is child-theme-only.

| Item | Action |
|------|--------|
| SQL migrations | Not required |
| WP options | No changes needed |
| Permalinks | Re-flush after activation (see below) — no DB schema change |
| Menus | Existing menus continue to work; assign to **Primary** location if header menu is empty |
| Front page | Ensure **Settings → Reading** still points to your static front page |
| Posts page | Ensure **Posts page** is set if using `/blog/` archive link |

---

## Plugin Requirements

These plugins must be **installed and active** on production:

| Plugin | Required | Purpose |
|--------|----------|---------|
| **GeneratePress** (parent theme) | Yes | Parent theme — must not be deleted |
| **GP Premium** | Yes | GP Elements, spacing, menu features |
| **Rank Math SEO** | Yes | Breadcrumbs, TOC block, schema, primary category |
| **GenerateBlocks** | Recommended | Block patterns for homepage query loops and article patterns; theme degrades gracefully without it |
| All-in-One WP Migration | Optional | Backups only |

Plugins already in repo (verify active on production):

- `gp-premium/`
- `seo-by-rank-math/`
- `all-in-one-wp-migration/`

**Do not** modify plugin files. All customizations are in the child theme.

---

## Theme Activation Steps

### 1. Upload files

**Option A — FTP/SFTP (FileZilla, WinSCP):**

1. Connect to GoViral hosting
2. Navigate to `public_html/visitbest.in/wp-content/themes/`
3. Upload `generatepress-child/` folder (merge/overwrite if exists)

**Option B — cPanel File Manager:**

1. Zip `generatepress-child/` locally
2. Upload zip to `wp-content/themes/`
3. Extract in place
4. Delete zip after extraction

**Option C — Git pull (if SSH enabled):**

```bash
cd ~/public_html/visitbest.in
git pull origin main
```

### 2. Verify parent theme

- [ ] Confirm `wp-content/themes/generatepress/` exists and is stock GP
- [ ] Do **not** delete or replace the parent theme

### 3. Activate child theme

1. WP Admin → **Appearance → Themes**
2. Find **Visitbest** (child theme, v2.0.0)
3. Click **Activate**
4. Site should load without white screen

### 4. Post-activation settings

- [ ] **Settings → Permalinks** → click **Save Changes** (flush rewrite rules)
- [ ] **Appearance → Menus** → confirm Primary menu assigned to `primary` location
- [ ] **Settings → Reading** → confirm static front page is set
- [ ] **Rank Math → General Settings → Breadcrumbs** → ensure breadcrumbs are enabled

### 5. Regenerate thumbnails (optional)

If card images look cropped wrong:

- Use a thumbnail regeneration plugin, or
- WP-CLI: `wp media regenerate --yes`

---

## Cache Clear Steps

After activation, clear caches in this order:

### 1. LiteSpeed Cache

- WP Admin → **LiteSpeed Cache → Toolbox → Purge All**
- Or cPanel → **LiteSpeed Web Cache Manager → Flush All**

### 2. WordPress object cache

- If using a persistent object cache plugin, purge from its admin panel

### 3. Rank Math cache

- Rank Math → **Status & Tools → Database Tools** → clear transients if needed

### 4. Browser cache

- Hard refresh: `Ctrl + Shift + R` (Windows) / `Cmd + Shift + R` (Mac)
- Or test in incognito/private window

### 5. CDN (if applicable)

- Purge Cloudflare or other CDN cache if fronted

---

## Rollback Steps (If Deployment Fails)

### Symptom: White screen / PHP fatal error

1. **Via FTP:** Rename `generatepress-child` to `generatepress-child-broken`
2. WP will fall back to parent GeneratePress theme automatically
3. Site should load (with old styling)
4. Check `wp-content/debug.log` or cPanel **Error Log** for the PHP error
5. Fix locally, re-upload, re-activate

### Symptom: Broken layout but site loads

1. WP Admin → **Appearance → Themes** → activate **GeneratePress** (parent)
2. Or switch to any previously working theme

### Symptom: Need full restore

1. Restore cPanel backup from pre-deploy snapshot
2. Or import All-in-One WP Migration `.wpress` backup
3. Re-deploy with fixes applied

### Git rollback (development)

```bash
git revert a80acb3   # or reset to previous known-good commit
git push origin main
```

Then re-upload reverted files via FTP.

### Rollback decision matrix

| Severity | Action |
|----------|--------|
| White screen | Immediate: rename child theme folder via FTP |
| Minor CSS issue | Keep active, hotfix CSS file via FTP |
| Major functionality break | Restore WP migration backup |
| Database issue | Restore SQL backup from phpMyAdmin |

---

## Post-Deployment QA Checklist

### Homepage

- [ ] Hero section renders (title, CTAs, category pills)
- [ ] Featured posts section shows 3 posts (no duplicates in Latest)
- [ ] Latest posts grid shows 6 posts
- [ ] Category browse section lists categories
- [ ] Newsletter CTA placeholder visible
- [ ] Footer CTA and footer columns render
- [ ] No `{{post_title}}` broken GB tags visible

### Header & Footer

- [ ] Logo / site title displays
- [ ] Primary navigation works (desktop + mobile)
- [ ] Search toggle opens/closes (Escape + outside click)
- [ ] Mobile menu positions correctly
- [ ] Footer links work (Home, Contact, Privacy Policy)

### Single Post

- [ ] Breadcrumbs render (Rank Math)
- [ ] Category badge, title, author, date, reading time
- [ ] Social share buttons open correct URLs
- [ ] Featured image loads (eager, no CLS)
- [ ] Desktop sticky TOC in sidebar
- [ ] Mobile in-content Rank Math TOC works
- [ ] Article content prose styling (headings, tables, images)
- [ ] Author box, related posts, prev/next navigation
- [ ] Newsletter CTA before footer
- [ ] Comments section hidden if comments disabled in WP settings

### Archives & Search

- [ ] Category archive: header, description, card grid, pagination
- [ ] Tag archive: same layout
- [ ] Search results: search form + results grid
- [ ] 404 page: message, homepage link, contact link, search form

### SEO & Technical

- [ ] Rank Math breadcrumbs on posts and archives
- [ ] `robots.txt` accessible
- [ ] Sitemap loads (`/sitemap_index.xml`) — fix if 500 persists
- [ ] No console JavaScript errors
- [ ] View source: no PHP warnings/notices

### Performance (Core Web Vitals spot-check)

- [ ] LCP: hero image loads fast on homepage and single posts
- [ ] CLS: no layout jump when opening search panel
- [ ] INP: header interactions feel responsive
- [ ] Run [PageSpeed Insights](https://pagespeed.web.dev/) on homepage + one single post

### Cross-device

- [ ] Desktop (1280px+)
- [ ] Tablet (768px)
- [ ] Mobile (375px)

---

## Deployment Sign-Off

| Role | Name | Date | Approved |
|------|------|------|----------|
| Developer | | | ☐ |
| Site owner | | | ☐ |

**Do not deploy to production until both boxes are checked.**

---

## Quick Reference Commands

```bash
# Verify remote matches local
git fetch origin
git log --oneline origin/main -7
git rev-parse HEAD origin/main

# On server (if SSH available)
cd public_html/visitbest.in
git pull origin main
wp theme list
wp theme activate generatepress-child
wp cache flush
wp rewrite flush
```

---

*Generated: 2026-07-08 | Child theme v2.0.0 | Commit target: `a80acb3` + performance fix*
