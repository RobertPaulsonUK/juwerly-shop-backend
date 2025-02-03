<?php

    namespace App\Traits;

    use App\Models\ProductType;

    trait HasType
    {

        /**
         * Generate type for model
         *
         * @return string
         */
        public function getTypeAttribute(): string
        {

            if ($this->hasVariations()) {
                return ProductType::VARIABLE->value;
            }

            return ProductType::SIMPLE->value;
        }

        /**
         * Check if model has variations
         *
         * @return bool
         */
        public function hasVariations(): bool
        {
            return $this->variations()->exists();
        }
    }
