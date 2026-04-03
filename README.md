# Colibri Starter — Portfolio

A clean, bilingual portfolio site built with [Colibri](https://github.com/colibri-php/colibri). No database required.

## Quick Start

```bash
composer create-project colibri-php/starter-portfolio my-portfolio --stability=alpha
cd my-portfolio
cp .env.example .env
php colibri serve
```

Visit `http://localhost:8000`.

## What's Included

- **Homepage** — Project listing with thumbnails, badges, and categories
- **Project detail pages** — Dynamic routes (`/projects/brand-identity`), hero image, client info, services
- **About page** — Static bio page
- **Contact page** — Contact info + working form with CSRF protection and validation
- **i18n** — English and French, with language switcher in the nav
- **SEO** — OpenGraph tags per project, meta descriptions, formatted site title
- **Security** — CSRF middleware, security headers on all routes

## Customizing

### Your Info

Edit `locales/en.json` and `locales/fr.json` to change:
- `site.name` — Your name
- `site.tagline` — Your title
- `about.bio` — Your bio
- Contact info is in `routes/web/contact.latte`

Update `config/app.php`:
```php
'name' => env('APP_NAME', 'Your Name'),
```

### Projects

Projects are JSON files in `data/projects/`. Each file supports localized content:

```json
{
    "title": {
        "en": "Project Title",
        "fr": "Titre du projet"
    },
    "description": {
        "en": "Short description.",
        "fr": "Description courte."
    },
    "details": {
        "en": "Longer description...",
        "fr": "Description plus longue..."
    },
    "category": "web",
    "year": 2026,
    "image": "my-project.png",
    "client": "Client Name",
    "services": ["Web Design", "Development"],
    "link": "#",
    "featured": true,
    "order": 1
}
```

- Add project images to `public/images/`
- Set `"featured": true` to show the "Featured" badge
- Set `"link"` to a live URL or `"#"` if not available
- The `order` field controls the display order on the homepage

### Adding a Project

1. Create `data/projects/my-project.json`
2. Add an image to `public/images/my-project.png`
3. Refresh — it appears automatically

### Removing a Project

Delete the JSON file from `data/projects/`.

### Languages

Translation files are in `locales/`. Add a new language:

1. Create `locales/es.json` (copy from `en.json`)
2. Add the prefix in `config/i18n.php`:
   ```php
   'prefixes' => [
       'en' => '/',
       'fr' => '/fr',
       'es' => '/es',
   ],
   ```

### Contact Form

The form validates input (name required, valid email, message min 10 characters) and logs submissions to `storage/logs/`.

To send real emails, update `.env`:

```env
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USER=your@gmail.com
MAIL_PASS=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME=Your Name
```

Then replace `Log::info(...)` in `routes/web/contact.php` with:

```php
Colibri\Mail\Mail::send(
    to: 'your@email.com',
    subject: 'New contact: ' . $request->input('name'),
    template: base_path('templates/emails/contact.latte'),
    data: $request->body(),
);
```

### Layout & Styles

- Layout: `templates/layouts/default.latte`
- Styles: `routes/web/_styles.css` (auto-injected, no build step)
- Error pages: `templates/errors/`

## Structure

```
├── config/            # App configuration
├── data/projects/     # Project data (JSON)
├── locales/           # Translation files (en.json, fr.json)
├── public/images/     # Project images
├── routes/web/
│   ├── _middleware.php # CSRF + security headers
│   ├── _styles.css    # Global styles
│   ├── index.latte    # Homepage (project listing)
│   ├── about.latte    # About page
│   ├── contact.php    # Contact form handler
│   ├── contact.latte  # Contact form template
│   └── projects/
│       └── [slug].*   # Project detail (PHP + Latte twin)
├── templates/
│   ├── layouts/       # Page layouts
│   ├── partials/      # Alerts, pagination
│   └── errors/        # Error pages
└── storage/           # Logs, cache, uploads
```

## Built With

- [Colibri](https://github.com/colibri-php/colibri) — File-based PHP micro-framework
- [Latte](https://latte.nette.org) — Templating engine
- No database, no build step, no JavaScript framework

## License

MIT
