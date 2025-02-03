<?php

    namespace App\Traits;

    use Illuminate\Support\Str;

    trait HasPageUrl
    {
        /**
         * Generate url attribute for pages
         *
         * @return string
         */
        public function getUrlAttribute(): string
        {
            $pageSlug = Str::slug($this->title);
            $frontendUrl = config('app.frontend_url');
            return "{$frontendUrl}/{$pageSlug}";
        }
    }
