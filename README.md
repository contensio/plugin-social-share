# Social Share

Adds share buttons to every post in Contensio. Four buttons out of the box - no configuration, no database, no admin UI needed.

**Supported networks:**
- X (Twitter)
- Facebook
- LinkedIn
- Copy link (clipboard API with visual confirmation)

---

## Requirements

- Contensio 2.0 or later

---

## Installation

### Composer

```bash
composer require contensio/plugin-social-share
```

### Manual

Copy the plugin directory into your Contensio installation and register the service provider via the admin plugin manager.

No migrations required.

---

## How it works

The plugin hooks into `contensio/frontend/post-after-content`, a render hook point that fires at the bottom of every post's `<article>` element (after body blocks and custom fields, before the article closes):

```php
Hook::add('contensio/frontend/post-after-content', function (Content $content, ContentTranslation $translation): string {
    $url   = urlencode(request()->url());
    $title = urlencode($translation->title ?? '');
    return view('social-share::partials.buttons', compact('url', 'title'))->render();
});
```

The hook receives the `Content` and `ContentTranslation` model instances so the plugin can access the post title and current URL.

---

## Styling

The buttons render inside a `<div class="mt-10 pt-8 border-t border-gray-200">` wrapper. Each button is a plain `<a>` or `<button>` with Tailwind utility classes - they adopt your theme's font and spacing automatically.

To override the button appearance, publish the view or target the elements in your theme's CSS:

```css
/* Example: make share buttons match your brand */
.contensio-share-wrap a,
.contensio-share-wrap button {
    border-radius: 999px;
    background: var(--color-primary);
    color: #fff;
    border-color: transparent;
}
```

Or override the Blade view in your theme:

```
resources/views/vendor/social-share/partials/buttons.blade.php
```

---

## Disabling specific buttons

To remove a network, publish the view and delete the relevant `<a>` block. Alternatively, fork the service provider and pass config flags through to the view:

```php
Hook::add('contensio/frontend/post-after-content', function (Content $content, ContentTranslation $translation): string {
    return view('social-share::partials.buttons', [
        'url'      => urlencode(request()->url()),
        'title'    => urlencode($translation->title ?? ''),
        'show_x'   => true,
        'show_fb'  => false,  // hide Facebook
        'show_li'  => true,
        'show_copy'=> true,
    ])->render();
});
```

---

## Hook reference

| Hook | Type | Args | Description |
|------|------|------|-------------|
| `contensio/frontend/post-after-content` | Render | `Content, ContentTranslation` | Inside `<article>`, after body content |
