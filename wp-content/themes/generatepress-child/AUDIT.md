# Visitbest Customization Audit

**Phase:** 2A  
**Date:** 2026-07-07  
**Status:** Documented — parent files retained, logic migrated to child theme

---

## Summary

| Area | Finding |
|------|---------|
| Child theme | **Created:** `generatepress-child` |
| Parent modifications | **Reverted:** `functions.php` custom hooks removed |
| Parent legacy files | **Retained:** not deleted (see below) |
| GP Elements | **Database-only** — not in Git repo |
| GenerateBlocks | **Was used on production** — plugin not in repo; CSS cache in uploads |

---

## 1. Custom Functions (Parent Theme)

### Migrated to child theme

| Function / Hook | Location (was) | Location (now) | Notes |
|-----------------|------------------|----------------|-------|
| `earphones_assets()` | `generatepress/functions.php` | `inc/templates/earphones.php` → `Visitbest_Earphones_Template::enqueue_assets()` | Uses `get_stylesheet_directory_uri()` |
| `@include_once more-functions.php` | `generatepress/functions.php` | Removed | File never existed |

### Parent `functions.php` status

- Lines 125–133 **removed** (restored to stock GeneratePress)
- Parent theme is now update-safe

---

## 2. Custom Templates

| File | Template Name | Slug / Usage | Child copy | Parent original |
|------|---------------|--------------|------------|-----------------|
| `page-earphones.php` | Earphones Page | Page slug: `earphones-under-2000` | `child/templates/page-earphones.php` | **Retained** in parent |
| — | — | No `front-page.php`, `home.php` | — | Uses GP default hierarchy |

### Issues in earphones template

| Issue | Severity | Phase 2B action |
|-------|----------|-----------------|
| Inline `<script src="script.js">` | Fixed in child copy | Removed; JS enqueued via PHP |
| Duplicate script load (enqueue + inline) | Fixed | Single enqueue only |
| Dark design system separate from main site | Medium | Restyle in later phase |
| Hardcoded Amazon image URLs | Low | Content concern, not theme |

---

## 3. Custom Assets (Parent Theme)

| File | Purpose | Child location | Parent original |
|------|---------|----------------|-----------------|
| `earphones.css` | Earphones landing styles (~645 lines) | `assets/css/templates/earphones.css` | **Retained** |
| `script.js` | Sticky bar, pill nav, FAQ toggle | `assets/js/earphones.js` | **Retained** |

---

## 4. GeneratePress Elements (`gp_elements` CPT)

**Not stored in files.** Configured in WordPress database on production.

### Known symptoms from live site

| Symptom | Likely cause |
|---------|--------------|
| Homepage shows `{{post_title}}`, `{{post_excerpt}}` | GenerateBlocks Query Loop using GP Premium dynamic tags incorrectly |
| Custom header/footer styling | GP Elements `site-header` / `site-footer` block types |
| Homepage layout sections | GenerateBlocks layouts stored in page content |

### Pre-Phase-2B export checklist (on staging/production)

- [ ] Export GP Premium settings (Appearance → GeneratePress → Import/Export)
- [ ] Document all Elements under Appearance → Elements
- [ ] Screenshot Customizer → Additional CSS
- [ ] Note Settings → Reading (homepage = which page?)

---

## 5. GenerateBlocks Usage

| Evidence | Location |
|----------|----------|
| Cached block CSS | `wp-content/uploads/generateblocks/style-*.css` (9 files) |
| Homepage query loop classes | `.gb-query-*`, `.gb-looper-*`, `.gb-loop-item-*` |
| Container width | `--gb-container-width: 1300px` |
| Fonts in layout | Playfair Display + Mulish (matches design plan) |

### Plugin status

| Item | Status |
|------|--------|
| `generateblocks` plugin in repo | **Not installed** |
| Theme preparation | `inc/integrations/generateblocks.php` |
| Block pattern category | `visitbest` registered when WP loads |
| Admin notice | Shown on Themes screen if GB missing |

### Install before Phase 2B

```bash
# Via WP Admin: Plugins → Add New → "GenerateBlocks"
# Or WP-CLI (if available):
wp plugin install generateblocks --activate
```

---

## 6. Typography & Fonts (Production)

| Font | Source | File |
|------|--------|------|
| Playfair Display | GP Font Library (self-hosted) | `uploads/generatepress/fonts/fonts.css` |
| Mulish | GP Font Library (self-hosted) | `uploads/generatepress/fonts/fonts.css` |

**Performance note:** Production `fonts.css` uses `font-display: auto`. Child theme design system uses `swap` for new CSS. Update GP Font Library settings in Phase 2E.

---

## 7. Rank Math SEO Integration

| Feature | Plugin support | Child theme support |
|---------|----------------|---------------------|
| Breadcrumbs | `[rank_math_breadcrumb]` / automatic | CSS in `components.css` |
| TOC block | `rank-math/toc-block` | CSS in `components.css` |
| Primary category | `rank_math_primary_category` meta | `Visitbest_Components::get_primary_category()` |
| Schema | Automatic JSON-LD | No changes needed |

---

## 8. Plugins Inventory

| Plugin | In repo | Notes |
|--------|---------|-------|
| GP Premium 2.5.5 | Yes | Elements, Menu Plus, Spacing, etc. |
| Rank Math 1.0.259.1 | Yes | SEO, TOC, breadcrumbs |
| All-in-One WP Migration | Yes | Backups |
| Filester | Empty dir | Orphan — no files |
| GenerateBlocks | **No** | Required for Phase 2B |

---

## 9. Items NOT Deleted (Per Phase 2A Rules)

These remain in the **parent** theme until explicit cleanup:

```
wp-content/themes/generatepress/
├── functions.php          ← reverted to stock (custom code removed)
├── page-earphones.php     ← legacy copy
├── earphones.css          ← legacy copy
└── script.js              ← legacy copy
```

When child theme is activated, WordPress uses child copies for templates and enqueues. Parent files are orphaned but harmless.

---

## 10. Activation Steps (Local Only)

1. WP Admin → Appearance → Themes
2. Activate **Visitbest** child theme
3. Install **GenerateBlocks** (free) when ready for Phase 2B
4. Verify earphones page still loads at `/earphones-under-2000/`
5. Do **not** deploy to live site until staging approval
