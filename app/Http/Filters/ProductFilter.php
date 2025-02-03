<?php

    namespace App\Http\Filters;

    use Illuminate\Database\Eloquent\Builder;

    class ProductFilter extends AbstractFilter
    {
        public const NAME = 'name';
        const CATEGORIES = 'categories';
        const PRICE = 'price';
        const OPTIONS = 'options';

        protected function getCallbacks(): array
        {
            return
                [
                    self::CATEGORIES => [$this,'categories'],
                    self::NAME => [$this,'name'],
                    self::PRICE => [$this,'price'],
                    self::OPTIONS => [$this,'options'],
                ];
        }

        public function name(Builder $builder,$value)
        {
            $builder->where('name','like',"%{$value}%");
        }

        public function categories(Builder $builder,$value)
        {
            $builder->whereHas('productCategory', function ($query) use ($value) {
                $query->whereIn('category_id', $value);
            });
        }
        public function price(Builder $builder, $value)
        {
            if (is_array($value)) {
                $builder->whereBetween('price', [$value['min'], $value['max']]);
            }
        }
        public function options(Builder $builder, $value)
        {
            if(!is_array($value)) {
                return;
            }
            foreach ($value as $attributeId => $optionIds) {
                if (!is_array($optionIds)) {
                    continue;
                }
                $builder->whereHas('options', function ($query) use ($attributeId, $optionIds) {
                    $query->whereHas('attribute', function ($query) use ($attributeId) {
                        $query->where('attributes.id', $attributeId);
                    })->whereIn('attribute_options.id', $optionIds);
                });
            }
        }
    }
