<?php

    namespace App\Service\Admin;

    use App\Models\Attribute;
    use App\Models\AttributeOption;
    use App\Models\Product;
    use App\Models\ProductCategory;
    use App\Models\Variation;
    use Illuminate\Support\Facades\DB;

    class ProductService
    {
        public array $attributes;
        public string $category;

        public array $relatedProducts;
        public array $crossels;
        public array $variations;


        public function store(array $data):Product
        {
            try {
               DB::beginTransaction();
               $rendered_data = $this->render_data($data);
                $product = Product::create($rendered_data);
                $this->createOrUpdateAttributes($product);

                if(!empty($this->relatedProducts)) {
                    $product->hasRelatedProducts()->attach($this->relatedProducts);
                }
                if(!empty($this->crossels)) {
                    $product->hasCrossells()->attach($this->crossels);
                }
                if(!empty($this->variations)) {
                    $product->variations()->createMany($this->variations);
                }
               DB::commit();
            } catch (\Exception $exception)
            {
                DB::rollBack();
                abort(404);
            }

            return $product;
        }

        public function update(array $data, Product $product)
        {
            try {
                DB::beginTransaction();
                $rendered_data = $this->render_data($data);
                $product->update($rendered_data);
                $this->createOrUpdateAttributes($product,true);
                $product->hasRelatedProducts()->sync($this->relatedProducts);
                $product->hasCrossells()->sync($this->crossels);
                $this->updateProductVariations($product);
                $product->fresh();
                DB::commit();
            }
            catch ( \Exception $exception) {
                DB::rollBack();
                abort(404);
            }
            return $product;
        }

        protected function render_data(array $data):array
        {
            $this->resetObjectProperties();
            if(isset($data['category'])) {
                $this->category = $data['category'];
                unset($data['category']);
                $data['category_id'] = $this->createOrUpdateCategory();
            }
            if(isset($data['attributes'])) {
                $this->attributes = $data['attributes'];
                unset($data['attributes']);
            }
            if(isset($data['relatedProducts'])) {
                $this->relatedProducts = $data['relatedProducts'];
                unset($data['relatedProducts']);
            }
            if(isset($data['crossels'])) {
                $this->crossels = $data['crossels'];
                unset($data['crossels']);
            }
            if(isset($data['variations'])) {
                $this->variations = $data['variations'];
                unset($data['variations']);
            }

            return $data;
        }

        protected function createOrUpdateCategory():int
        {
            if($this->category === '') {
                return 0;
            }
            $category = ProductCategory::firstOrCreate(['name' => $this->category]);

            return $category->id;
        }

        protected function createOrUpdateAttributes(Product $product, bool $isUpdating = false): void
        {
            if (empty($this->attributes)) {
                return;
            }

            $syncData = [];

            foreach ($this->attributes as $attribute_data) {
                $attribute = Attribute::firstOrCreate(
                    ['title' => $attribute_data['attribute']['title']]
                );

                foreach ($attribute_data['options'] as $option_data) {
                    $option = isset($option_data['id'])
                        ? AttributeOption::find($option_data['id'])
                        : AttributeOption::create(
                            ['title' => $option_data['title'], 'attribute_id' => $attribute->id]
                        );

                    $syncData[$attribute->id] = ['option_id' => $option->id];
                }
            }

            if ($isUpdating) {
                $product->attributes()->sync($syncData);
            } else {
                $product->attributes()->attach($syncData);
            }
        }

        protected function updateProductVariations(Product $product)
        {
            $prevVariationsIds = $product->variations()->pluck('id')->toArray();
            $updateVariationsIds = [];
            if (empty($this->variations)) {
                $product->variations()->whereIn('id', $prevVariationsIds)->delete();
                return;
            }
            foreach ($this->variations as $variationData) {
                if(!isset($variationData['id'])) {
                    $product->variations()->create($variationData);
                    continue;
                }
                $variation = Variation::findOrFail($variationData['id']);
                $updateVariationsIds[] = $variation->id;

                unset($variationData['id']);

                $variation->update($variationData);
            }
            $product->variations()->whereIn('id', array_diff($prevVariationsIds, $updateVariationsIds))->delete();
        }
        protected function resetObjectProperties()
        {
            $this->category = '';
            $this->attributes = [];
            $this->crossels = [];
            $this->relatedProducts = [];
            $this->variations = [];
        }


    }
