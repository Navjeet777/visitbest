# Visitbest — Development Guide

WordPress development documentation for the Visit-Best project (visitbest.in).

**Phase:** 2A complete — child theme, design system, reusable components  
**Live site:** Do not deploy until staging approval

---

## Theme Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    WordPress 7.0                            │
├─────────────────────────────────────────────────────────────┤
│  GeneratePress 3.6 (parent)     ← never edit directly       │
│       ↓                                                     │
│  generatepress-child 1.0        ← all custom code here      │
│       ↓                                                     │
│  GP Premium 2.5                 ← Elements, Menu Plus, etc. │
│  Rank Math SEO                  ← breadcrumbs, TOC, schema  │
│  GenerateBlocks (free)          ← required for Phase 2B     │
└─────────────────────────────────────────────────────────────┘
```

### Design layers

| Layer | Location | Purpose |
|-------|----------|---------|
| Design tokens | `assets/css/design-system/tokens.css` | Colors, radii, layout constants |
| Typography | `assets/css/design-system/typography.css` | Fluid type scale, heading classes |
| Spacing | `assets/css/design-system/spacing.css` | 8px scale, containers, grids |
| Primitives | `buttons.css`, `forms.css`, `shadows.css` | Buttons, inputs, shadows |
| Components | `assets/css/components/components.css` | Post cards, author box, etc. |
| Templates | `assets/css/templates/` | Page-specific CSS (earphones) |
| Block editor | `theme.json`, `assets/css/editor.css` | Gutenberg / GenerateBlocks palette |

---

## Folder Structure

```
wp-content/themes/generatepress-child/
├── style.css                          # Theme header only
├── functions.php                      # Bootstrap
├── theme.json                         # Block editor design tokens
├── AUDIT.md                           # Customization audit (Phase 2A)
│
├── inc/
│   ├── class-theme-setup.php          # Theme supports, image sizes
│   ├── class-assets.php               # CSS/JS enqueue
│   ├── class-components.php           # Component render API
│   ├── integrations/
│   │   └── generateblocks.php         # GB pattern category, notices
│   └── templates/
│       └── earphones.php              # Earphones page assets
│
├── assets/
│   ├── css/
│   │   ├── design-system/             # Tokens, typography, spacing, etc.
│   │   ├── components/                # Component styles
│   │   ├── templates/                 # Per-template CSS
│   │   └── editor.css                 # Block editor
│   └── js/
│       └── earphones.js               # Earphones page interactions
│
├── template-parts/
│   └── components/                    # Reusable PHP components
│       ├── post-card.php
│       ├── featured-post-card.php
│       ├── affiliate-product-card.php
│       ├── cta-block.php
│       ├── author-box.php
│       ├── related-posts.php
│       ├── category-pills.php
│       └── section-heading.php
│
└── templates/
    └── page-earphones.php             # Custom page template
```

---

## Reusable Components

### PHP API

All components are rendered via `Visitbest_Components`:

```php
// Post card for current or specific post
Visitbest_Components::post_card( array(
    'post_id'      => 123,
    'show_excerpt' => true,
    'show_meta'    => true,
    'class'        => 'my-modifier',
) );

// Featured post card
Visitbest_Components::featured_post_card( array( 'post_id' => 123 ) );

// Amazon affiliate product card
Visitbest_Components::affiliate_product_card( array(
    'title'     => 'Titan Workwear Quartz',
    'url'       => 'https://amzn.to/...',
    'image_url' => 'https://...',
    'meta'      => '₹2,000 – ₹5,000',
) );

// CTA block
Visitbest_Components::cta_block( array(
    'title'       => 'Get the best guides in your inbox',
    'text'        => 'Weekly curated lists from Visit-Best.',
    'button_text' => 'Subscribe',
    'button_url'  => '#newsletter',
    'variant'     => 'default', // or 'dark'
) );

// Author box
Visitbest_Components::author_box( array(
    'author_id' => 1,
    'variant'   => 'compact', // or 'full'
) );

// Related posts (same category)
Visitbest_Components::related_posts( array(
    'post_id' => get_the_ID(),
    'count'   => 3,
    'title'   => 'You May Also Like',
) );

// Category navigation pills
Visitbest_Components::category_pills( array(
    'active_id'  => get_queried_object_id(),
    'scrollable' => true,
) );

// Section heading with optional action link
Visitbest_Components::section_heading( array(
    'eyebrow'      => 'Latest',
    'title'        => 'Recent Posts',
    'description'  => 'Expert-curated guides.',
    'action_label' => 'View all',
    'action_url'   => '/blog/',
) );
```

### CSS class reference

| Component | Root class | Modifier classes |
|-----------|------------|------------------|
| Post Card | `.vb-post-card` | — |
| Featured Post Card | `.vb-featured-post-card` | — |
| Affiliate Card | `.vb-affiliate-card` | — |
| CTA Block | `.vb-cta-block` | `.vb-cta-block--dark` |
| Author Box | `.vb-author-box` | `.vb-author-box--compact` |
| Related Posts | `.vb-related-posts` | — |
| Category Pills | `.vb-category-pill` | `.is-active`, `.vb-category-pills--scroll` |
| Section Heading | `.vb-section-heading` | — |
| Buttons | `.vb-btn` | `.vb-btn--primary`, `--cta`, `--secondary`, `--ghost`, `--sm`, `--lg`, `--block` |

### Image sizes

| Name | Size | Use |
|------|------|-----|
| `visitbest-card` | 640×360 | Post cards |
| `visitbest-featured` | 1200×675 | Featured cards |
| `visitbest-affiliate` | 400×400 | Affiliate products |

---

## Hook Locations (GeneratePress)

Use these GP hooks in Phase 2B via GP Premium Elements or child theme `functions.php`:

| Hook | Priority | Planned use |
|------|----------|-------------|
| `generate_before_header` | 5 | Announcement bar (optional) |
| `generate_after_header` | 10 | Breadcrumbs (Rank Math) |
| `generate_before_main_content` | 10 | Archive page headers |
| `generate_before_content` | 10 | Single post compact author box |
| `generate_after_entry_content` | 10 | Affiliate blocks, in-content ads |
| `generate_after_entry_content` | 20 | Full author box |
| `generate_after_entry_content` | 30 | Related posts |
| `generate_after_primary_content_area` | 10 | Sidebar TOC (desktop) |
| `generate_before_footer` | 10 | Newsletter CTA |
| `generate_footer` | 5 | Custom footer element |
| `wp_enqueue_scripts` | 20 | Design system CSS (done) |

### Rank Math shortcodes

```php
// Breadcrumbs (when enabled in Rank Math settings)
echo do_shortcode( '[rank_math_breadcrumb]' );
```

---

## Template Hierarchy

```
Front page (static page)
└── page.php (GP parent) → page content + GenerateBlocks blocks

Blog index
└── index.php (GP parent) → will override in Phase 2B

Single post
└── single.php → content-single.php
    └── Phase 2B: hooks for author, related, TOC sidebar

Category archive
└── index.php / archive.php
    └── Phase 2B: card grid via template or Element

Custom page template
└── templates/page-earphones.php (child theme)

Search
└── search.php (GP parent)
    └── Phase 2B: card grid
```

---

## GenerateBlocks (Phase 2B Prep)

### Install

1. WP Admin → Plugins → Add New
2. Search **GenerateBlocks** by GeneratePress
3. Install and activate (free version)

### Pattern category

The child theme registers a `visitbest` block pattern category for future layouts.

### Dynamic content rules

| Tag type | Works in | Does NOT work in |
|----------|----------|------------------|
| GP `{{post_title}}` | GP Elements Header/Hero | Gutenberg paragraphs, GB Query Loops |
| GB dynamic tags | GenerateBlocks Query Loop | Raw HTML blocks |
| PHP components | Child theme templates, hooks | Block editor directly |

**Homepage fix (Phase 2B):** Rebuild query loop with GenerateBlocks dynamic data or GP Elements `loop-template`.

---

## Performance Guidelines

| Rule | Implementation |
|------|----------------|
| No `@import` on frontend | All CSS via `wp_enqueue_style()` |
| No inline styles | CSS classes only |
| No hardcoded colors | Use `--vb-*` custom properties |
| Lazy load images | `loading="lazy"` on card images |
| Font display | `font-display: swap` (update GP Font Library in 2E) |
| Minimal JS | Only `earphones.js` for legacy template |
| CSS weight | Design system split into cacheable files |

### Core Web Vitals targets

| Metric | Target |
|--------|--------|
| LCP | < 2.5s |
| INP | < 200ms |
| CLS | < 0.1 |

---

## Rank Math Compatibility

- Breadcrumb CSS: `.rank-math-breadcrumb`
- TOC CSS: `#rank-math-toc`
- Primary category: `rank_math_primary_category` post meta
- No changes to Rank Math plugin files
- Schema output unchanged

---

## Deployment Workflow

```
Local development
       │
       ▼
git commit + push (GitHub)
       │
       ▼
Staging (AI1WM clone) — test child theme activation
       │
       ▼
Production (GoViral) — manual FTP / git pull
       │
       ▼
Clear LiteSpeed cache + verify
```

### Deploy checklist

- [ ] Child theme activated
- [ ] GenerateBlocks installed (Phase 2B+)
- [ ] `wp-config.php` not in commit
- [ ] GP Premium settings exported before major changes
- [ ] Cache flushed after deploy
- [ ] Earphones page tested
- [ ] Rank Math breadcrumbs/TOC verified

### Do not deploy to live until

- Phase 2B tested on staging
- Homepage layout verified
- User approval received

---

## Local Setup Reminder

```bash
git clone https://github.com/Navjeet777/visitbest.git
cd visitbest
# Copy wp-config.php from secure storage
# Import database from staging export
# Sync wp-content/uploads/ separately
```

Activate **Visitbest** child theme in WP Admin → Appearance → Themes.

---

## Phase 2B — Homepage, Header & Footer

### Homepage architecture

The homepage bypasses broken database page content via `front-page.php`. No database changes required.

```
front-page.php
└── Visitbest_Homepage::render()
    ├── template-parts/homepage/hero.php
    ├── template-parts/homepage/featured-posts.php
    ├── Ad slot: homepage-mid-1
    ├── template-parts/homepage/latest-posts.php
    ├── template-parts/homepage/category-browse.php
    ├── template-parts/homepage/newsletter.php
    └── Ad slot: homepage-bottom
```

| Setting | Value |
|---------|-------|
| Sidebar | Removed on front page (`no-sidebar`) |
| Content width | Full width (`full-width-content`) |
| Data source | `WP_Query` (latest posts) |
| Broken `{{post_title}}` | Not rendered — `front-page.php` replaces page template |

### Header architecture

```
generate_header hook
└── Visitbest_Layout::render_header()
    └── template-parts/layout/header.php
        ├── Logo / site title
        ├── wp_nav_menu( primary )
        ├── Search toggle → expandable panel
        └── Mobile menu toggle (≤1024px)
```

| Feature | Implementation |
|---------|----------------|
| Sticky | CSS `position: sticky` + `.is-scrolled` shadow |
| Search | `searchform.php` child override |
| Mobile nav | `.is-menu-open` class via `header.js` |
| Accessibility | `aria-expanded`, `aria-controls`, `role="banner"` |

### Footer architecture

```
generate_footer hook
└── Visitbest_Layout::render_footer()
    └── template-parts/layout/footer.php
        ├── Footer CTA (dark variant)
        ├── 4-column grid: About · Categories · Quick Links · Contact
        ├── Newsletter placeholder (disabled)
        └── Copyright bar + Amazon disclosure
```

GP default footer widgets and copyright bar are removed via `Visitbest_Layout`.

### GenerateBlocks patterns registered

| Pattern slug | Title | Purpose |
|--------------|-------|---------|
| `visitbest/homepage-hero` | Homepage Hero | Hero copy block |
| `visitbest/homepage-featured-query` | Featured Posts Query | GB Query Loop with `useDynamicData` |
| `visitbest/homepage-latest-query` | Latest Posts Grid | 3-col query loop (correct dynamic tags) |
| `visitbest/homepage-category-browse` | Category Browse | Category section intro |
| `visitbest/homepage-newsletter-cta` | Newsletter CTA | Newsletter placeholder |
| `visitbest/adsense-slot` | AdSense Placeholder | Reserved ad slot |

Query loop patterns use GenerateBlocks `useDynamicData` (`post-title`, `post-excerpt`, `featured-image`) — **not** GP Premium `{{post_title}}` tags.

### Static preview (local)

Open `wp-content/themes/generatepress-child/preview/homepage-preview.html` in a browser to preview layout/CSS without a database connection.

---

## Related Documentation

| File | Purpose |
|------|---------|
| [README.md](../../README.md) | Project overview, hosting |
| [AUDIT.md](wp-content/themes/generatepress-child/AUDIT.md) | Customization audit |

---

## Coding Standards

### PHP (WordPress)

- Follow [WordPress PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/)
- Prefix all functions/classes with `Visitbest_` or place inside namespaced classes
- Always use `ABSPATH` guard at file top
- Escape output: `esc_html()`, `esc_attr()`, `esc_url()`
- Sanitize input: `sanitize_text_field()`, `absint()`
- Use `wp_enqueue_style()` / `wp_enqueue_script()` — never hardcode asset tags in templates
- Use `get_template_part()` or `Visitbest_Components::render()` for reusable markup
- No business logic in template files — keep logic in `inc/` classes

### CSS

- All values via `--vb-*` custom properties defined in `tokens.css`
- BEM-style component naming: `.vb-{component}__{element}--{modifier}`
- Mobile-first media queries: `min-width` breakpoints only
- No `!important` unless overriding third-party with documented reason
- No inline styles in PHP templates
- Frontend CSS loaded via `Visitbest_Assets` only (no `@import` chain on frontend)

### JavaScript

- Vanilla JS only — no jQuery unless required by GP core
- Use `{ passive: true }` on scroll listeners
- Enqueue in footer (`true` param) with version constant
- Page-specific JS scoped to template (e.g. `earphones.js`)

### Git

- One commit per phase
- Never commit `wp-config.php`, uploads, cache, or logs
- Write commit messages in imperative mood with phase prefix: `Phase 2A: ...`

### Accessibility

- Semantic HTML (`<article>`, `<nav>`, `<section>`, `<time>`)
- `aria-label` on navigation regions
- `aria-current="page"` on active category pills
- Focus-visible styles on all interactive elements
- Alt text on all images; decorative images use `aria-hidden`

---

## Phase Roadmap

| Phase | Status | Scope |
|-------|--------|-------|
| **2A** | ✅ Complete | Child theme, design system, components |
| **2B** | ✅ Complete | Homepage, header, footer |
| **2C** | Pending approval | Single post template |
| **2D** | Planned | Category archive, search |
| **2E** | Planned | Performance pass |
| **2F** | Planned | Production deploy |
