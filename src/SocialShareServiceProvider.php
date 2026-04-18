<?php

namespace Contensio\Plugins\SocialShare;

use Contensio\Models\Content;
use Contensio\Models\ContentTranslation;
use Contensio\Support\Hook;
use Illuminate\Support\ServiceProvider;

class SocialShareServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'social-share');

        Hook::add('contensio/frontend/post-after-content', function (Content $content, ContentTranslation $translation): string {
            $url   = urlencode(request()->url());
            $title = urlencode($translation->title ?? '');

            return view('social-share::partials.buttons', compact('url', 'title'))->render();
        });
    }
}
