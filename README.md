# Cool Air USA — WordPress FSE Theme

A custom Full Site Editing block theme for Cool Air USA HVAC & Plumbing.

## Quick Start

1. **Install the theme**
   - Zip the `cool-air-usa/` folder
   - WP Admin → **Appearance → Themes → Add New → Upload Theme**
   - Activate it

2. **Create the WordPress pages** (Pages → Add New)
   The theme auto-routes pages by slug. Create these pages with the exact slugs below:

   | Page Title          | Slug                | Template (auto)              |
   |---------------------|---------------------|------------------------------|
   | About               | `about`             | `page-about.html`            |
   | Contact             | `contact`           | `page-contact.html`          |
   | Membership          | `membership`        | `page-membership.html`       |
   | Financing           | `financing`         | `page-financing.html`        |
   | Careers             | `careers`           | `page-careers.html`          |
   | Specials & Deals    | `specials`          | `page-specials.html`         |
   | Brands              | `brands`            | `page-brands.html`           |
   | Service Areas       | `service-areas`     | `page-service-areas.html`    |
   | Privacy Policy      | `privacy-policy`    | `page-privacy-policy.html`   |
   | Terms of Service    | `terms-of-service`  | `page-terms-of-service.html` |

3. **Create service pages** under `/services/{slug}/`:
   Create a parent page **Services** (slug: `services`), then 13 child pages with these exact slugs:
   - `ac-repair`, `ac-install`, `ac-maintenance`, `commercial`, `emergency`
   - `duct-cleaning`, `duct-repair`, `duct-install`
   - `uv-lights`, `air-purifiers`, `air-filters`, `thermostats`
   - `plumbing`

   Each child page is auto-routed by its `page-{slug}.html` template. If WordPress does not auto-select it, assign the matching template in Page Attributes.
   Child page content can be left empty — the theme renders it from `inc/data/services.php`.

4. **Set dynamic header/footer data**
   - Appearance → Menus: assign menus to **Primary Header Menu**, **Mobile Menu**, footer columns, and legal links.
   - Appearance → Customize → **Cool Air USA Company Details**: update phone, email, address, portal URL, top bar text, footer copy, and license number.
   - Appearance → Editor: edit the Header/Footer template parts if you need to replace the default dynamic blocks.

5. **Set the homepage**: Settings → Reading → "A static page" → pick a "Home" page (or leave default; `front-page.html` will render automatically).

6. **Permalinks**: Settings → Permalinks → "Post name" (`/%postname%/`)

## Architecture

```
cool-air-usa/
├── style.css                       Theme header
├── theme.json                      Design tokens (colors, fonts, layout)
├── functions.php                   Setup, asset enqueue, block registration
├── index.php                       Required WP fallback
│
├── templates/                      FSE block templates
│   ├── front-page.html             Homepage (renders <!-- wp:cool-air-usa/homepage /-->)
│   ├── page-{slug}.html            Per-page templates (one per slug above)
│   ├── page.html                   Generic page fallback
│   ├── single.html                 Blog post
│   ├── index.html                  Blog index
│   └── 404.html
│
├── parts/                          Template parts referenced by templates
│   ├── header.html                 Renders <!-- wp:cool-air-usa/site-header /-->
│   └── footer.html                 Renders <!-- wp:cool-air-usa/site-footer /-->
│
├── inc/                            All PHP rendering logic
│   ├── page-data.php               Brands, reviews, counties data
│   ├── render-home.php             Homepage entry — calls each section
│   ├── render-services.php         Service-page renderer (slug-aware)
│   ├── render-pages.php            Loads page renderers + ca_page_hero() helper
│   ├── data/
│   │   └── services.php            All 13 service definitions (title, intro, issues, process, benefits)
│   └── render/
│       ├── site-header.php         Top nav with dropdowns + emergency bar
│       ├── site-footer.php         4-column footer
│       ├── home-hero.php           Hero with split layout
│       ├── home-stats.php          Rotating stats bar + family-owned band
│       ├── home-services.php       8 service cards
│       ├── home-why.php            6 feature cards with tilt
│       ├── home-reviews.php        Google reviews section
│       ├── home-process.php        4-step process with animated van
│       ├── home-brands.php         Marquee brand list
│       ├── home-map.php            County cards (homepage map)
│       ├── home-membership.php     Membership CTA band
│       ├── home-gallery.php        3D rotating project gallery
│       ├── home-emergency.php      Emergency dispatch band
│       └── page-{slug}.php         Inner-page renderers
│
└── assets/
    ├── css/
    │   ├── main.css                Imports all part stylesheets
    │   └── parts/                  Modular CSS (base, buttons, header, hero, etc.)
    ├── js/
    │   ├── nav.js                  Dropdowns, mobile menu
    │   └── main.js                 Reveal, parallax, stats rotator, process van,
    │                               tilt, 3D gallery, contact form
    └── images/
        └── logo4t.png
```

## How the Dynamic Block System Works

Templates reference dynamic blocks like `<!-- wp:cool-air-usa/service-page /-->`. These are registered in `functions.php` with PHP `render_callback`s:

| Block                              | Renders                                              |
|------------------------------------|------------------------------------------------------|
| `cool-air-usa/site-header`         | Top nav + emergency info bar                         |
| `cool-air-usa/site-footer`         | 4-column footer + bottom legal bar                   |
| `cool-air-usa/homepage`            | All 11 homepage sections in order                    |
| `cool-air-usa/service-page`        | Service page — reads slug from `get_queried_object()`|
| `cool-air-usa/about-page`          | About page                                           |
| `cool-air-usa/contact-page`        | Contact page (with form)                             |
| `cool-air-usa/membership-page`     | Membership plans                                     |
| `cool-air-usa/financing-page`      | Financing options                                    |
| `cool-air-usa/careers-page`        | Open jobs + benefits                                 |
| `cool-air-usa/specials-page`       | Current specials grid                                |
| `cool-air-usa/brands-page`         | All 24 brand cards                                   |
| `cool-air-usa/service-areas-page`  | Counties + city directory                            |
| `cool-air-usa/legal-page`          | Privacy or Terms (`kind` attribute)                  |

## Customization

- **Colors / typography**: edit `theme.json` (no PHP needed)
- **Service-page content**: edit `inc/data/services.php` (one entry per slug)
- **Brands list**: `ca_brands()` in `inc/page-data.php`
- **Reviews**: `ca_reviews()` in `inc/page-data.php`
- **Cities by county**: `ca_counties()` in `inc/page-data.php`
- **Header/footer menus**: Appearance → Menus
- **Phone / email / address / portal URL**: Appearance → Customize → Cool Air USA Company Details
- **Page body content**: edit the page in WordPress; custom templates render page content after the preserved designed sections.
- **Layout**: edit the relevant `inc/render/*.php` file
- **Styles**: edit the relevant `assets/css/parts/*.css` file

## Backend TODO (developer)

The contact form (`/contact/`) currently shows a success message client-side only. To wire up actual submission:

1. Pick a handler — recommended: `admin-post.php` action or a REST route
2. In `inc/render/page-contact.php`, change the `<form>` to POST to your endpoint
3. Add a nonce field, CSRF protection, validation, email send (`wp_mail`), and spam protection
4. Update `assets/js/main.js` `initContactForm()` if you want fetch-based AJAX submit instead of full page reload

## Requirements

- WordPress 6.3+ (Full Site Editing)
- PHP 8.0+
- Modern browser (uses CSS custom properties, `color-mix()`, IntersectionObserver)

## License

GPL-2.0-or-later (WordPress theme requirement)
