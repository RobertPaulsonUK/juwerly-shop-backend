<?php

    namespace App\Service\Admin;

    use App\Models\Attribute;
    use App\Models\AttributeOption;
    use Illuminate\Support\Facades\DB;

    class AttributeService
    {
        public function store(array $data):Attribute
        {
            try {
               DB::beginTransaction();
                $attribute = Attribute::create(['title' => $data['title']]);
                if(isset($data['options'])) {
                    $this->create_attribute_options($attribute,$data['options']);
                }
               DB::commit();
            } catch (\Exception $exception)
            {
                DB::rollBack();
                abort(404);
            }
            return $attribute;
        }

        public function update(array $data, Attribute $attribute):Attribute
        {
            try {
                DB::beginTransaction();
                $attribute->update(array(
                    'title' => $data['title']
                ));
                if(isset($data['options_ids'])) {
                    $this->update_attribute_options($attribute,$data['options_ids']);
                }
                if(isset($data['new_options'])) {
                    $this->create_attribute_options($attribute,$data['new_options']);
                }
                $attribute->fresh();
                DB::commit();
            }
            catch ( \Exception $exception) {
                DB::rollBack();
                abort(404);
            }
            return $attribute;
        }

        public function create_attribute_options(Attribute $attribute,array $options)
        {
            if(empty($options)) {
                return;
            }
            $formattedOptions = array_map(function ($option) {
                return ['title' => $option];
            }, $options);
            $attribute->options()->createMany($formattedOptions);

        }

        public function update_attribute_options( Attribute $attribute, array $options)
        {
            $old_options = $attribute->options()->pluck('id');
            foreach ($old_options as $option_id) {
                if(!in_array($option_id,$options)) {
                    $option_attribute = AttributeOption::find($option_id);
                    $option_attribute->delete();
                }
            }
        }
    }
