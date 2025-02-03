<?php

    namespace App\Traits;

    use Illuminate\Support\Str;

    trait HasSlug
    {
        public static function bootHasSlug()
        {
            static::creating(function ($model) {
                $model->slug = $model->slug ?? Str::slug($model->name);
            });
            static::updating(function ($model) {
                if ($model->isDirty('name')) {
                    $model->slug = Str::slug($model->name);
                }
            });
        }
        public function getRouteKeyName()
        {
            return 'slug';
        }

        /**
         * Generate url attribute for models
         *
         * @return string
         */
        public function getUrlAttribute(): string
        {
            $frontendUrl = config('app.frontend_url');
            $modelName = Str::kebab(class_basename($this));
            return "{$frontendUrl}/{$modelName}/{$this->slug}";
        }
    }
