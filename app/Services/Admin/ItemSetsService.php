<?php


namespace App\Services\Admin;


use App\Classes\DataTableHelper\DataTableHelper;
use App\ItemTranslation;
use App\Models\Items\ItemSet;

class ItemSetsService
{
    public static function generateTable($request = null): DataTableHelper
    {
        $columns = [
            trans('items.items_files') => [
                trans('common.products'),
                trans('common.language'),
                trans('common.action'),
            ]
        ];


        $table = new DataTableHelper(route('admin.sets.getData'), $columns, [
            'id' => 'set',
            'perPage' => 50,
            'ordering' => false,
            "showVisibilityColumnsButton" => false,
            'scriptOptions' => [
                'columnDefs' => [
                    ['targets' => '"_all"', 'className' => '"text-center"']
                ],
                'columns' => [
                    ['data' => '"products"'],
                    ['data' => '"language"'],
                    ['data' => '"action"']
                ]
            ]
        ]);
        return $table;
    }

    public static function generateDataForTable($request) :array
    {
        $data = [];
        $sets = ItemSet::all();

        $name = [];
        $sorts = $sets->groupBy('set_id');

        foreach ($sorts as  $set) {
            foreach (config('estore.content-lang') as $key => $value){
                if($key == $set[0]['lang'])
                {
                    $lang = $value;
                }
            }
                $data[] = [

                    'products' => $set->pluck('item_name'),
                    'language' => $lang,
                    'action' => view('admin.items.sets.action_index', ['id' => $set[0]['set_id']])->render(),
                ];

        }
        return $data;
    }

    public function store($request)
    {
        $setId = ItemSet::get('set_id')->last();
        if($setId == null){
            $setId = 1;
        }else{
            $setId = $setId->set_id +1;
        }

        $set = new ItemSet();
        $set->set_id = $setId;
        $set->item_id = $request['firstProduct'];
        $set->lang = $request['language'];
        $set->item_name = ItemTranslation::where('item_id', $request['firstProduct'])
            ->where('lang', $request['language'])->value('name');
        $set->price_without_set = $request['price_without_set'];
        $set->price_with_set = $request['price_with_set'];
        $set->save();


        foreach ($request['sets'] as $key => $setItem)
        {
            $setNewItem = new ItemSet();
            $setNewItem->set_id = $set->set_id;
            $setNewItem->item_id = $setItem['product'] ?? $request['product'];
            $setNewItem->lang = $request['language'];
            $setNewItem->item_name = ItemTranslation::where('item_id', $setItem['product'] ?? $request['product'])
                ->where('lang', $request['language'])->value('name');
            $setNewItem->price_without_set = $setItem['price_without_set'];
            $setNewItem->price_with_set = $setItem['price_with_set'];
            $setNewItem->save();
        }
    }

    public function update($id, $request)
    {
        $setItems = ItemSet::where('set_id', $id)->get();
        foreach ($setItems as $item)
        {
            foreach ($request['price_with_set'] as $key => $priceWithSet){
                if($key == $item->id)
                {
                    $item->price_with_set = $priceWithSet;
                    $item->save();
                }
            }
        }
        if(isset($request['sets'])){
            foreach ($request['sets'] as $key => $set){
                if(isset($set['product']))
                {
                    $itemName = ItemTranslation::where('item_id',$set['product'])->value('name');
                }else{
                    $itemName = ItemTranslation::where('item_id',$request['product'])->value('name');
                }

                $newSetItem = new ItemSet();
                $newSetItem->set_id = $setItems[0]['set_id'];
                $newSetItem->item_id = $set['product'] ?? $request['product'];
                $newSetItem->item_name = $itemName;
                $newSetItem->lang = $item->lang;
                $newSetItem->price_without_set = $set['price_without_set'];
                $newSetItem->price_with_set = $set['price_with_set'];
                $newSetItem->save();

            }
        }
    }
}
