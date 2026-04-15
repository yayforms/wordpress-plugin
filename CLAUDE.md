# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

WordPress plugin (distributed via the wordpress.org plugin directory) that embeds Yay! Forms into WP sites via a shortcode. The plugin is a thin wrapper: it registers an admin page with a shortcode generator, exposes a `[yayforms]` shortcode that renders HTML + enqueues the external embed script from `embed.yayforms.link/next/embed.js`. No build step, no package manager, no test suite.

## Layout

- `yayforms.php` — the whole plugin. Single file. All PHP lives here.
- `scripts.js` — admin-page JS (vanilla + jQuery) that powers the shortcode generator form and the AJAX preview.
- `style.css` — admin-page styling.
- `readme.txt` — wordpress.org plugin directory readme (WP-specific format, not markdown).
- `yayforms/` — snapshot of the SVN layout used to publish to wordpress.org (`assets/`, `tags/`, `trunk/`). **Do not edit `yayforms/trunk/` directly** — the release flow copies the root files into `yayforms/trunk/` and cuts a tag in `yayforms/tags/`.

## Architecture notes

- **Two nonce sites, two different meanings.** `yayforms_preview_shortcode` (AJAX handler at `wp_ajax_yayforms_preview`) enforces the nonce strictly — that's the real CSRF boundary, since it calls `do_shortcode` on user input and requires `manage_options`. The nonce check inside `yayforms_shortcode` itself is defensive/secondary: it only triggers when `wp_doing_ajax()` AND the nonce is present. Don't "harden" the shortcode check without understanding that the AJAX endpoint above is the one that matters.
- **Script enqueue has a fallback path.** `yayforms-embed` is registered on both `wp_enqueue_scripts` and `admin_enqueue_scripts`. In admin/AJAX contexts (page builder previews — Elementor, Divi, Bricks, etc.) `wp_footer` may not run, so `yayforms_shortcode` calls `wp_print_scripts('yayforms-embed')` inline via `ob_start()` as a fallback. Keep this generic — don't re-introduce builder-specific `$_GET` checks (that was a prior regression; see the `hotfix/error-security` PR history).
- **Display modes** are switched on the `mode` shortcode attribute: `standard`, `full-page`, `popup`, `slider`, `popover`, `side-tab`. Each renders a different `data-yf-*` element that the external `embed.js` hydrates. Adding a new mode = new `case` in the `switch` inside `yayforms_shortcode` + matching UI in `scripts.js::updateFormOptions()`.
- **Admin page** is rendered by `yayforms_shortcode_generator` and only enqueues `style.css` / `scripts.js` when `$hook == 'toplevel_page_yayforms-generator'`. `wp_localize_script` exposes `yayforms_admin.ajax_url` and `yayforms_admin.nonce` to the admin JS.

## Workflow

- **Branch model:** work on `develop`, merge into `main` via PR. `main` corresponds to the currently released version on wordpress.org. Hotfixes branch off `main` as `hotfix/*`.
- **No build, no tests.** Validate PHP with `php -l yayforms.php` before committing. There is no linter config and no test runner in the repo.
- **Version bumps** must be kept in sync across three places: the `Version:` header in `yayforms.php`, `Stable tag:` in `readme.txt`, and the version string passed to `wp_register_script`/`wp_enqueue_style` (currently `'1.3'`) — the last one controls cache-busting for end users.
- **Releases** go to wordpress.org via SVN; the `yayforms/` subfolder mirrors that structure. Do not commit changes inside `yayforms/trunk/` as part of feature work — only as part of a release cut.

## Gotchas

- The plugin embeds two large inline SVG literals in `yayforms.php` (base64 logo + admin-page logo). They are huge but intentional — don't extract them to files without understanding that the admin menu icon must be a data URI.
- `$_GET`/`$_REQUEST`/`$_POST` access in this file is reviewed by the wordpress.org Plugin Check — always `sanitize_text_field(wp_unslash($_FOO['key']))`, never raw access.
- Protocol-relative URLs (`//embed.yayforms.link/...`) are used intentionally in `wp_register_script` to match the parent page's scheme. Inline fallback `<script>` tags should use explicit `https://`.
