<?php


namespace App\Repositories\Admin;


use App\Item;
use App\ItemCategory;
use Illuminate\Http\Request;
class ItemRepository
{

    public static function getTableData(Request $request)
    {
        $items = Item::all();
        $recordsFiltered = $items->count();

        if (!empty($request->start))
        {
            $items = $items->skip($request->start);
        }

        $items = $items->take($request->length);

        return [
            'data' => $items,
            'recordsFiltered' => $recordsFiltered,
        ];
    }
}
