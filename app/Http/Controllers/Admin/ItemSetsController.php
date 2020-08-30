<?php

namespace App\Http\Controllers\Admin;

use App\Classes\DataTableHelper\DataTableHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Items\CreateSetRequest;
use App\Http\Requests\Items\UpdateSetRequest;
use App\Item;
use App\ItemTranslation;
use App\Models\Items\ItemSet;
use App\Repositories\Admin\ItemSetsRepository;
use App\Services\Admin\ItemSetsService;
use App\Services\DataTableService;
use Illuminate\Http\Request;

class ItemSetsController extends Controller
{
    public function index()
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

        return view('admin.items.sets.index', [
            'table' => $table,
        ]);
    }

    public function getData(Request $request)
    {
        $itemsData = ItemSetsRepository::getTableData($request);
        $itemsData['data'] = ItemSetsService::generateDataForTable($itemsData['data']);
        $itemsData['query'] = DataTableService::createQuery($request);

        return $itemsData;
    }

    public function create($id = null)
    {

        $item = '';
        if($id != null){
            $item = Item::with('translations')->where('id', $id)->get();

        }

        return view('admin.items.sets.create', [
            'id' => $id,
            'item' => $item,
        ]);
    }

    public function store(CreateSetRequest $request, ItemSetsService $service)
    {
        $service->store($request->all());
        return redirect()->route('admin.sets.index');

    }

    public function getProduct(Request $request)
    {
        if(isset($request['id'])){
            $items = ItemTranslation::where('item_id', $request['id'])->where('lang', $request['lang'])->get();
        }else {
            $items = ItemTranslation::where('lang', $request['lang'])->get();
        }
        if($items){
            $response = [
                'success' => true,
                'item' => view('admin.items.sets.render_product', ['items' => $items])->render(),
            ];
        }else {
            $response = [
                'success' => false
            ];
        }
        return response()->json($response);
    }

    public function getPrice(Request $request)
    {
        $price = ItemTranslation::where('item_id', $request['id'])->where('lang', $request['lang'])->get('price');

        if($price){
            $response = [
              'success' => true,
              'price' => $price[0]['price'],
               'lang' =>  $request['lang'],
            ];
        }else{
            $response = [
              'success' => false
            ];
        }
        return response()->json($response);
    }

    public function edit($id)
    {
        return view('admin.items.sets.edit', [
            'id' => $id,
            'sets' => ItemSet::where('set_id', $id)->get(),
        ]);
    }

    public function update($id, UpdateSetRequest $request, ItemSetsService $service)
    {
        $service->update($id, $request->all());
        return redirect()->route('admin.sets.index');
    }

    public function destroy($id)
    {
        $destroy = ItemSet::where('set_id', $id);
        $destroy->delete();
        return redirect()->back();
    }

    public function deleteProduct(Request $request)
    {
        $deleteProduct = ItemSet::find($request['id'])->delete();
        $response = [
            'success' => true,
            'message' => trans('common.successfully_deleted')
        ];
        return response()->json($response);
    }

}
