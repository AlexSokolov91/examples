<?php


namespace App\Repositories\Admin;

use App\Models\Items\ItemSet;
use Illuminate\Http\Request;
class ItemSetsRepository
{
    public static function getTableData(Request $request)
    {
        $sets = ItemSet::all()->unique('set_id');
        $recordsFiltered = $sets->count();
        if (!empty($request->start))
        {
            $sets = $sets->skip($request->start);
        }
        $sets = $sets->take($request->length);
        return [
            'data' => $sets,
            'recordsFiltered' => $recordsFiltered,
        ];
    }
}
