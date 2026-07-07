# Visitbest

WordPress website for [visitbest.in](https://visitbest.in), hosted on GoViral shared hosting (cPanel / LiteSpeed). This repository tracks WordPress core, themes, plugins, and site configuration files for Git-based development and deployment.

## Project structure

```
visitbest/
├── .htaccess              # Apache rewrite rules (WordPress + LiteSpeed + PHP handler)
├── ads.txt                # Google AdSense ads.txt
├── index.php              # WordPress front controller
├── litespeed.conf         # W3TC WebP rewrite rules (server-level)
├── license.txt            # WordPress GPL license
├── readme.html            # WordPress default readme (safe to keep)
├── wp-activate.php        # Multisite activation
├── wp-admin/              # WordPress admin (core)
├── wp-blog-header.php     # Loads WP environment for themes
├── wp-comments-post.php   # Comment submission handler
├── wp-config-sample.php   # Config template (tracked — copy to wp-config.php on server)
├── wp-content/            # Themes, plugins, and runtime content
│   ├── index.php          # Silence is golden
│   ├── plugins/           # Installed plugins (tracked)
│   ├── themes/            # Installed themes (tracked)
│   ├── uploads/           # Media library (ignored — lives on server only)
│   ├── cache/             # W3 Total Cache output (ignored)
│   └── ai1wm-backups/     # Migration plugin backups (ignored)
├── wp-cron.php            # WP-Cron handler
├── wp-includes/           # WordPress core libraries
├── wp-links-opml.php
├── wp-load.php
├── wp-login.php
├── wp-mail.php
├── wp-settings.php
├── wp-signup.php
├── wp-trackback.php
└── xmlrpc.php
```

### Installed extensions

| Type   | Slug               | Name                              |
|--------|--------------------|-----------------------------------|
| Theme  | `generatepress`    | GeneratePress                     |
| Plugin | `gp-premium`       | GP Premium (GeneratePress add-on) |
| Plugin | `seo-by-rank-math` | Rank Math SEO                     |
| Plugin | `all-in-one-wp-migration` | All-in-One WP Migration    |
| Plugin | `filester`         | *(empty directory — see notes)*   |

**WordPress version:** 7.0  
**PHP handler (server):** ea-php82 (cPanel)

## What Git tracks vs ignores

| Tracked | Ignored |
|---------|---------|
| WordPress core (`wp-admin/`, `wp-includes/`, root PHP files) | `wp-config.php` (secrets) |
| `wp-config-sample.php` | `wp-content/uploads/` (media) |
| Themes & plugins in `wp-content/` | Cache, logs, backups |
| `.htaccess`, `ads.txt`, `litespeed.conf` | Hosting temp files, OS junk |

See [`.gitignore`](.gitignore) for the full list.

## Local setup (developers)

1. **Clone the repository**
   ```bash
   git clone https://github.com/Navjeet777/visitbest.git
   cd visitbest
   ```

2. **Create `wp-config.php` on the server only** — never commit it.
   ```bash
   cp wp-config-sample.php wp-config.php
   ```
   Fill in database credentials, authentication keys/salts, and table prefix (`wpk4_` on production). Generate new salts at [api.wordpress.org/secret-key/1.1/salt/](https://api.wordpress.org/secret-key/1.1/salt/).

3. **Import the database** from a sanitized export (phpMyAdmin or hosting backup). The database is not stored in this repo.

4. **Sync media uploads** separately (FTP, cPanel File Manager, or rsync):
   ```
   wp-content/uploads/
   ```

5. **Set file permissions** (typical shared hosting):
   - Directories: `755`
   - Files: `644`
   - `wp-config.php`: `440` or `600` if your host allows

## Deployment workflow (GoViral shared hosting)

This site uses **shared hosting with no CI/CD pipeline**. Deployments are manual and should never overwrite production secrets or media.

### Recommended flow

```
┌─────────────┐     push      ┌──────────┐     pull/FTP     ┌─────────────────┐
│  Local dev  │ ────────────► │  GitHub  │ ───────────────► │ GoViral / cPanel │
└─────────────┘               └──────────┘                  └─────────────────┘
```

1. **Develop locally** or in a staging copy of the site.
2. **Commit & push** code changes (themes, plugins, custom PHP) to GitHub.
3. **Deploy to production** using one of:
   - **Git pull on server** (if SSH/Git is enabled on GoViral)
   - **FTP / SFTP** (FileZilla, WinSCP) — upload only changed files
   - **cPanel File Manager** — for small hotfixes
4. **Never deploy** `wp-config.php`, `wp-content/uploads/`, or cache folders.
5. **After deploy**, clear LiteSpeed / W3TC cache from WordPress admin or hosting panel.
6. **Database changes** (plugin settings, content) are made on production or migrated via export/import — not via Git.

### Pre-deploy checklist

- [ ] Changes tested on staging or local copy
- [ ] `wp-config.php` not in the commit
- [ ] No `error_log`, cache, or backup files staged
- [ ] Plugin/theme updates backed up (AI1WM or hosting backup)
- [ ] Cache flushed after deploy

### Rollback

- Use hosting cPanel **backups** or an **All-in-One WP Migration** export taken before deploy.
- `git revert` on GitHub, then re-deploy the previous commit via FTP/pull.

## Security notes

- `wp-config.php` contains database credentials and auth salts — it is excluded from Git.
- Rotate database password and WordPress salts if credentials were ever exposed.
- Keep WordPress core, themes, and plugins updated via the admin dashboard.
- `xmlrpc.php` is present (default). Disable or restrict if not needed to reduce brute-force surface.
- Rank Math and GP Premium are commercial/licensed plugins — ensure licenses are documented outside Git.

## Repository

- **Remote:** https://github.com/Navjeet777/visitbest.git
- **Branch:** `main`

## Support & hosting

- **Host:** GoViral shared hosting (cPanel, LiteSpeed, PHP 8.2)
- **Domain:** visitbest.in
- **Document root:** `public_html/visitbest.in/` (on server; path may differ locally)
