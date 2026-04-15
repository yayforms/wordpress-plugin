# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

WordPress plugin (distributed via the wordpress.org plugin directory) that embeds Yay! Forms into WP sites via a shortcode. The plugin is a thin wrapper: it registers an admin page with a shortcode generator, exposes a `[yayforms]` shortcode that renders HTML + enqueues the external embed script from `embed.yayforms.link/next/embed.js`. No build step, no package manager, no test suite.

## Layout

- `yayforms.php` — the whole plugin. Single file. All PHP lives here.
- `scripts.js` — admin-page JS (vanilla, no jQuery) that powers the shortcode generator form and the AJAX preview. Uses `fetch` + `URLSearchParams` and the Clipboard API.
- `hidden-fields.js` — tiny script loaded as a `'before'` inline dependency of `yayforms-embed`. Reads `window.location.search` and hydrates `data-yf-hidden` on every widget so URL params reach the form client-side (cache-safe).
- `style.css` — admin-page styling.
- `readme.txt` — wordpress.org plugin directory readme (WP-specific format, not markdown).
- `assets/` — SVG assets used by the admin menu icon and the admin page header.
- `languages/` — `.pot` / `.po` / `.mo` translation files. Text domain: `yayforms`.
- `yayforms/` — snapshot of the SVN layout used to publish to wordpress.org (`assets/`, `tags/`, `trunk/`). **Do not edit `yayforms/trunk/` directly** — the release flow copies the root files into `yayforms/trunk/` and cuts a tag in `yayforms/tags/`.

## Architecture notes

- **Single CSRF boundary, not two.** The AJAX handler `yayforms_preview_shortcode` (at `wp_ajax_yayforms_preview`) is the only place that validates the nonce. It requires `manage_options` and, since 1.4, also rejects any shortcode that doesn't start with `[yayforms`. The `yayforms_shortcode` callback itself has no nonce check — the previous "only-if-present" check was bypassable by omitting the nonce and is removed.
- **`YAYFORMS_VERSION` / `YAYFORMS_EMBED_URL` constants.** Defined once at the top of `yayforms.php` and reused for every `wp_register_script` / `wp_enqueue_style` / JS localization. The plugin header `Version:` and readme `Stable tag:` stay in sync manually; bump all three when releasing.
- **Hidden-field hydration is client-side.** The plugin does not read `$_GET` server-side. Every widget renders with `data-yf-hidden=""`. `hidden-fields.js` is injected as a `'before'` inline dependency of `yayforms-embed` via `wp_add_inline_script`, so it runs before the external embed loader and fills in `data-yf-hidden` with the current URL's query params. This keeps cached HTML identical across visitors while still forwarding each visitor's real params to the form — no opt-in from site owners, no allow-list. Do not re-introduce PHP `foreach ($_GET …)` into the shortcode; it's both a Plugin Check violation and a cache-correctness bug.
- **Script enqueue fallback.** `yayforms-embed` is registered on both `wp_enqueue_scripts` and `admin_enqueue_scripts`. In admin/AJAX contexts (page builder previews — Elementor, Divi, Bricks, etc.) `wp_footer` may not run, so `yayforms_shortcode` calls `wp_print_scripts('yayforms-embed')` inline via `ob_start()`. Because `hidden-fields.js` is a `'before'` inline attached to the same handle, `wp_print_scripts` prints both in order. Keep this generic — don't re-introduce builder-specific `$_GET` checks.
- **Display modes** are switched on the `mode` shortcode attribute: `standard`, `full-page`, `popup`, `slider`, `popover`, `side-tab`. Each renders a different `data-yf-*` element that the external `embed.js` hydrates. Adding a new mode = new `case` in the `switch` inside `yayforms_shortcode`, matching UI in `scripts.js::updateFormOptions()`, and extending the selector list inside `hidden-fields.js` if the new element uses a new `data-yf-*` root attribute.
- **Admin page** is rendered by `yayforms_shortcode_generator` and only enqueues `style.css` / `scripts.js` when `$hook === 'toplevel_page_yayforms-generator'`. `wp_localize_script` exposes `yayforms_admin.ajax_url`, `yayforms_admin.nonce`, `yayforms_admin.embed_url`, and the `i18n` map. All user-visible JS strings come from `i18n` so translations work without a separate JS i18n pipeline.
- **Translations.** Text domain is `yayforms`, files live in `/languages`. Regenerate the POT with `wp i18n make-pot . languages/yayforms.pot` after adding or changing strings.

## Workflow

- **Branch model:** work on `develop`, merge into `main` via PR. `main` corresponds to the currently released version on wordpress.org. Hotfixes branch off `main` as `hotfix/*`.
- **No build, no tests.** Validate PHP with `php -l yayforms.php` before committing. Validate JS parses with `node -e "new Function(require('fs').readFileSync('scripts.js','utf8'))"`. There is no linter config and no test runner in the repo.
- **Version bumps** must be kept in sync across two places: the `Version:` header in `yayforms.php` and `Stable tag:` in `readme.txt`. Also update the `YAYFORMS_VERSION` constant at the top of `yayforms.php` — it's the single source of truth for script/style cache-busting.
- **Releases** go to wordpress.org via SVN; the `yayforms/` subfolder mirrors that structure. Do not commit changes inside `yayforms/trunk/` as part of feature work — only as part of a release cut.

## Gotchas

- The plugin embeds two large inline SVG literals in `yayforms.php` (base64 logo + admin-page logo). They are huge but intentional — don't extract them to files without understanding that the admin menu icon must be a data URI.
- `$_GET`/`$_REQUEST`/`$_POST` access in this file is reviewed by the wordpress.org Plugin Check — always `sanitize_text_field(wp_unslash($_FOO['key']))`, never raw access.
- Protocol-relative URLs (`//embed.yayforms.link/...`) are used intentionally in `wp_register_script` to match the parent page's scheme. Inline fallback `<script>` tags should use explicit `https://`.
