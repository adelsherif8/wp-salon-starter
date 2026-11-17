# WP Salon Starter

A hand-coded WordPress **parent theme for salon and spa sites** (`salon-master`) plus one **client child theme**
(`salon-child-maison`), built with plain PHP templates and **Tailwind CSS**. No page builder.
The demo salon, "Maison Rouge", and all its names, addresses, phone numbers and prices are fictional.

It's a personal project that shows how I'd structure an agency theme library: one parent theme holds the
templates, data model, schema and tracking, and each client gets a small child theme with their brand.
A fix in the parent reaches every site; a client's look never needs a new CSS build.

<!-- screenshots coming -->

## What's in it

| Piece | Where | Notes |
| --- | --- | --- |
| Plain PHP templates | `salon-master/*.php`, `template-parts/` | `front-page`, `archive-salon_service` (menu), `archive-salon_stylist` (find your stylist), `single-salon_stylist`, `archive/single-salon_location`, `page`, `index`, `404` |
| Data model | `inc/post-types.php` | Services (+ categories), Stylists (+ levels), Locations |
| Custom fields | `inc/fields.php` | Registered in code with ACF (free), so they're versioned with the theme. `salon_field()` falls back to post meta if ACF is off |
| Tailwind | `tailwind.config.js`, `assets/src/input.css` | One build scans **both** themes' PHP. Colours and fonts are CSS variables, so a child theme rebrands with tokens |
| Brand tokens | `inc/brand.php`, child `functions.php` | `salon_brand_tokens` filter; values are sanitised before printing |
| Child theme override | `salon-child-maison/template-parts/hero.php` | Same data, different hero layout |
| Booking | `inc/booking.php` | `salon_book_button()` picks the stylist's, then the location's, then the default booking URL (Zenoti, Phorest, SalonBiz...). `[salon_booking_widget]` only iframes allowlisted booking hosts |
| Schema | `inc/schema.php` | JSON-LD `HairSalon` / `BeautySalon` / `DaySpa` / `NailSalon` per location: address, geo, phone, opening hours, `ReserveAction` |
| GA4 / GTM | `inc/tracking.php`, `assets/app.js` | GTM container from the Customizer; `book_now_click`, `phone_click`, `directions_click`, `stylist_filter` pushed to the `dataLayer` |
| Gravity Forms | `inc/gravity-forms.php` | Fills a "salon-locations" field from the Locations, and pushes `generate_lead` on confirmation. **Written against the documented hooks but not run here** (Gravity Forms needs a licence) |
| HTML email | `emails/holiday-gloss.html` | Table layout, inline CSS, VML button for Outlook, dark-mode tweaks, Mailchimp merge tags (`*\|FNAME\|*`, `*\|UNSUB\|*`, `*\|LIST:ADDRESSLINE\|*`) |
| Customizer | `inc/brand.php` | GTM ID, default booking URL, schema type, hero tagline: things an account manager can change without a developer |

### ACF free vs PRO
On ACF PRO, stylist specialties and location hours would be **repeaters** and site-wide settings an **options page**.
Here they're one-per-line textareas parsed by `salon_lines()`, and settings live in the Customizer, so the theme
has no paid dependency.

### Tailwind gotchas this handles
- The `content` paths include the PHP of the parent **and** every child theme. Miss a folder and those classes
  vanish in the production build.
- Class names are always written in full. Building them from pieces (`"bg-" . $color`) gets them purged.
- `ink` and `paper` are RGB channel variables, so opacity utilities like `border-ink/10` still work.

## Run it locally
Requirements: Node 18+, Docker (or Colima).

```bash
npm install
npm run build        # Tailwind -> salon-master/assets/app.css
npm run wp:start     # WordPress at http://localhost:8891 (admin / password)
npx wp-env run cli wp theme activate salon-child-maison
npx wp-env run cli wp plugin activate advanced-custom-fields
npm run wp:seed      # demo salon: 2 locations, 8 services, 4 stylists, menu, front page
```

## How AI was used
Built quickly with Claude Code from a brief: a parent/child theme library for salons, Tailwind with per-client
tokens, menu / stylists / locations, booking links, local-search schema and GA4 events. One thing caught in
review: a PHP 8-only `str_ends_with()` call in a theme that declares PHP 7.4 support.
