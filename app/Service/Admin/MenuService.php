<?php

    namespace App\Service\Admin;

    use App\Models\Menu;
    use App\Models\MenuItem;
    use Illuminate\Support\Facades\DB;
    use phpDocumentor\Reflection\DocBlock\Tags\Return_;

    class MenuService
    {

        public function store(array $data):Menu
        {
            try {
                DB::beginTransaction();
                $menu = Menu::create(['title' => $data['title']]);
                if(isset($data['items'])) {
                    $this->create_menu_items_from_request($data['items'],$menu->id);
                }
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                abort(404);
            }

            return $menu;
        }


        public function update(array $data,Menu $menu)
        {
            try {
                DB::beginTransaction();
                $menu->update(['title' => $data['title']]);
                if(isset($data['items'])) {
                    $this->update_menu_items_from_request($data['items'],$menu);
                }
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                abort(404);
            }
            return $menu;
        }

        public function create_menu_items_from_request(array $items,int $menu_id)
        {
            if(empty($items)) {
                return;
            }
            foreach ($items as $item) {
                $this->create_menu_items_with_children($item,$menu_id);
            }

        }

        public function update_menu_items_from_request(array $items,Menu $menu)
        {
            if(empty($items)) {
                return;
            }
            $previous_items = $menu->menuItems()->pluck('id');
            $existing_items = [];

            foreach ($items as $item)
            {
                if(!isset($item['id'])) {
                    $this->create_menu_items_with_children($item,$menu->id);
                    continue;
                }
                $existing_items[] = $item['id'];
                $formatted_data = $this->get_menu_item_args($item,$menu->id);
                $menu_item = MenuItem::find($item['id']);
                $menu_item->update($formatted_data);
                if(isset($item['children'])) {
                    foreach ($item['children'] as $item_child) {
                        if(!isset($item_child['id'])) {
                            $this->create_menu_items_with_children($item_child,$menu->id,$item['id']);
                            continue;
                        }
                        $existing_items[] = $item_child['id'];
                        $item_child_data = $this->get_menu_item_args($item_child,$menu->id);
                        $item_child_data['parent_id'] = $item['id'];
                        MenuItem::find($item_child['id'])
                                ->update($item_child_data);
                    }
                }
            }

            foreach ($previous_items as $prev_item)
            {
                if(!in_array($prev_item,$existing_items)) {
                    MenuItem::find($prev_item)->delete();
                }
            }

        }

        protected function create_menu_items_with_children(array $item,int $menu_id, int|null $parent_id = null)
        {
            $formatted_data = $this->get_menu_item_args($item,$menu_id);
            if($parent_id) {
                $formatted_data['parent_id'] = $parent_id;
            }
            $menu_item = MenuItem::create($formatted_data);

            if( !empty($item['children'])) {
                foreach ($item['children'] as &$child) {
                    $child['menu_id'] = $menu_id;
                }
                $menu_item->children()->createMany($item['children']);
            }
        }

        protected function get_menu_item_args(array $item,int $menu_id):array
        {
            return array(
                'title' => $item['title'],
                'url' => $item['url'],
                'sort' => $item['sort'],
                'menu_id' => $menu_id
            );
        }

    }
