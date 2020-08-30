<?php

namespace App\Http\Controllers\Admin;

use App\Classes\DataTableHelper\DataTableHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Items\CreateOrUpdateAttributeRequest;
use App\Item;
use App\Models\Attribute;
use App\Models\ItemAttribute;
use App\Repositories\Admin\AttributeRepository;
use App\Services\Admin\AttributeService;
use App\Services\DataTableService;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {

        $columns = [
            trans('items.items_files') => [
                trans('common.name'),
                trans('common.action'),
            ]
        ];
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

        return view('admin.items.attributes.index', ['table' => $table]);
    }

    public function getData(Request $request)
    {
        $attributesData = AttributeRepository::getTableData($request);
        $attributesData['data'] = AttributeService::generateDataTable($attributesData['data']);
        $attributesData['query'] = DataTableService::createQuery($request);
        return $attributesData;

    }

    public function create()
    {
        return view('admin.items.attributes.create');
    }

    public function store(CreateOrUpdateAttributeRequest $request, AttributeService $service)
    {
        $service->saveAttribute($request->all());
        return redirect()->route('admin.attributes.attributes.index');
    }

    public function edit($id)
    {
        return view('admin.items.attributes.edit',['attributes' => Attribute::where('attribute_id', $id)->get(),
            'id' => $id,

            ]);
    }

    public function update($id, CreateOrUpdateAttributeRequest $request, AttributeService $service)
    {
        $service->updateAttribute($id, $request->all());
        return redirect()->route('admin.items.index');
    }

    public function destroy($id, AttributeService $service)
    {
        $service->deleteAttribute($id);
        return redirect()->back();
    }

    public function itemAttributes($id, $lang)
    {
        return view('admin.items.attributes.item_attributes', [$id, $lang,
        'attributes' => Attribute::with('itemAttribute')->where('lang', $lang)->get(),
            'itemAttributes' => ItemAttribute::with('attribute')
                ->where('item_id', $id)->where('lang', $lang)->get(),
            'id' => $id, 'lang' => $lang,
            'parentItems' => Item::with(['translations' => function($query) use ($lang) {
                $query->where('lang', $lang);
            }])->where('parent', 1)->get(),
            'item' => Item::find($id)
        ]);
    }

    public function storeItemAttribute(CreateOrUpdateAttributeRequest $request, $id, $lang, AttributeService $service)
    {
        $service->saveItemAttribute($request->all());
        return redirect()->route('admin.items.edit', $id);
    }

    public function deleteItemAttribute(Request $request)
    {
        ItemAttribute::find($request->id)->delete();

        $response = [
            'success' => true,
            'message' => trans('common.successfully_deleted')
        ];
        return response()->json($response);
    }

    public function getParentAttribute(Request $request)
    {
        $itemAttributes = ItemAttribute::where('item_id', $request->id)->where('lang', $request->lang)->get();
        if($itemAttributes){

            $response = [
                'success' => true,
                'item' => view('admin.items.attributes.attribute_render', ['itemAttributes' => $itemAttributes,
                'request' => $request])->render(),

                ];
        }else {
            $response = [
                'success' => false
                ];
            }
        return response()->json($response);
    }
}
