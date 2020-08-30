<?php


namespace App\Services\Admin;


use App\Classes\DataTableHelper\DataTableHelper;
use App\Item;
use App\Models\Attribute;
use App\Models\ItemAttribute;

class AttributeService
{
    public static function generateDataForTable($request = null): DataTableHelper
    {
        $columns = [
            trans('items.items_files') => [
                trans('common.name'),
                trans('common.action'),
            ]
        ];

        $data = self::generateDataTable($request);

        $table = new DataTableHelper(route('admin.attributes.getData'), $columns, [
            'id' => 'attribute',
            'perPage' => 50,
            'ordering' => false,
            "showVisibilityColumnsButton" => false,
            'scriptOptions' => [
                'columnDefs' => [
                    ['targets' => '"_all"', 'className' => '"text-center"']
                ],
                'columns' => [
                    ['data' => '"name"'],
                    ['data' => '"action"']
                ]
            ]
        ]);
        return $table;
    }

    public static function generateDataTable($values): array
    {
        $data = [];
        $attributes = Attribute::where('lang', auth()->user()->lang)->get();

        foreach ($attributes as $attribute) {
            $data[] = [
                'name' => $attribute->name,
                'action' => view('admin.items.attributes.action_index', ['id' => $attribute->attribute_id])->render()
            ];
        }
        return $data;

    }



    public function saveItemAttribute($request)
    {
        $parent = Item::where('id', $request['item_id'])->update(['parent' => $request['parent'] ?? 0]);

            if (isset($request['attr'])){

            foreach ($request['attr'] as $key => $attr) {
                $itemAttribute = ItemAttribute::where('item_id', $request['item_id'])->where('attribute_id', $attr['attribute_id'])->first();

            if (isset($itemAttribute)) {
                $itemAttribute->update(['value' => $attr['value'], 'parent' => $request['parent'] ?? 0]);
            } else {
                $attr = new ItemAttribute();
                $attr->item_id = $request['item_id'];
                $attr->parent = $request['parent'] ?? 0;
                $attr->attribute_id = $request['attr'][$key]['attribute_id'];
                $attr->value = $request['attr'][$key]['value'];
                $attr->lang = $request['langKey'];
                $attr->save();
            }
         }
            }else{
                $itemAttribute = ItemAttribute::where('item_id', $request['item_id'])->where('attribute_id', $request['attribute_id'])->first();
                    $itemAttribute->update('value', $request['value']);
            }
    }

    public function saveAttribute($request)
    {
        $attrId = Attribute::get('attribute_id')->last();
        if($attrId == null){
            $attrId = 1;
        }else{
            $attrId = $attrId->attribute_id +1;
        }

        foreach ($request['name'] as $key => $item) {
            $attr = new Attribute();
            $attr->attribute_id = $attrId;
            $attr->name = $item;
            $attr->lang = $key;
            $attr->save();
        }
    }

    public function updateAttribute($id, $request)
    {
        $updates = Attribute::where('attribute_id', $id)->get();
        foreach ($updates as $update) {
            $update->name = $request['name'][$update->lang];
            $update->save();
        }
    }

    public function deleteAttribute($id)
    {
        $delete = Attribute::where('attribute_id', $id);
        $delete->delete();
    }
}
