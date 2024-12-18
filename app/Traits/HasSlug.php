<?php

    namespace App\Traits;

    use Illuminate\Support\Str;

    trait HasSlug
    {
        public static function bootHasSlug()
        {
            static::creating(function ($model) {
                $model->slug = $model->slug ?? Str::slug($model->name . '-' . $model->id);
            });
        }
        public function getRouteKeyName()
        {
            return 'slug';
        }
    }
