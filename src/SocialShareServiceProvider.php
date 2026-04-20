<?php

namespace Contensio\Plugins\SocialShare;

use Contensio\Models\Content;
use Contensio\Models\ContentTranslation;
use Contensio\Support\Hook;
use Illuminate\Support\ServiceProvider;

class SocialShareServiceProvider extends ServiceProvider
{
    protected string $ns = 'contensio-social-share';

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', $this->ns);

        Hook::add('contensio/frontend/post-after-content', function (Content $content, ContentTranslation $translation): string {
            $url   = urlencode(request()->url());
            $title = urlencode($translation->title ?? '');

            return view($this->ns . '::partials.buttons', compact('url', 'title'))->render();
        });
    }
}
