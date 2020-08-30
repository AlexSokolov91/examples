<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Items\CreateOrUpdatePhotoRequest;
use App\ItemCategory;
use App\Models\Attribute;
use App\Classes\DataTableHelper\DataTableHelper;
use App\Classes\DataTableHelper\Filter\SelectFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Items\SavePreviewPhotoRequest;
use App\Item;
use App\ItemTranslation;
use App\Models\ItemAttribute;
use App\Models\Items\ItemSet;
use App\Models\ModelFile;
use App\Models\Taxonomy;
use App\Repositories\Admin\ItemRepository;
use App\Services\Admin\ItemService;
use App\Services\DataTableService;
use App\Services\ModelFilesService;
use Illuminate\Http\Request;
use App\Http\Requests\Items\CreateOrUpdateItemRequest;
class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = [
            trans('items.items_files') => [
                trans('common.image'),
                trans('common.name'),
                trans('common.action'),
            ]
        ];

        $table = new DataTableHelper(route('admin.items.getData'), $columns, [
            'id' => 'item',
            'perPage' => 50,
            'ordering' => false,
            "showVisibilityColumnsButton" => false,
            'scriptOptions' => [
                'columnDefs' => [
                    ['targets' => '"_all"', 'className' => '"text-center"']
                ],
                'columns' => [
                    ['data' => '"image"'],
                    ['data' => '"name"'],
                    ['data' => '"action"']
                ]
            ]
        ]);

        $table->addFilter(new SelectFilter('categories', Taxonomy::where('type', 'item_category')->pluck('name', 'id'), [
            'label'          => trans('common.categories'),
            'skipPermission' => true,
            'url' => '/ajax/find?entity=categories',
        ]));


        return view('admin.items.index', ['table' => $table]);
    }

    public function getData(Request $request)
    {
        $itemsData = ItemRepository::getTableData($request);
        $itemsData['data'] = ItemService::generateDataForItemsTable($itemsData['data']);
        $itemsData['query'] = DataTableService::createQuery($request);

        return $itemsData;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.items.create',
        ['categories' => Taxonomy::with(['translates' => function ($query){
            $query->where('lang', auth()->user()->lang);
        }])->type('item_category')
        ->get(),
            'attributes' => Attribute::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrUpdateItemRequest $request, ItemService $service)
    {
        $item = $service->saveItem($request);
        return redirect()->route('admin.items.updateItem', [$item->id, $item->translations[0]->lang]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $table = ItemService::generateEditTable($id);
        return view('admin.items.edit', ['table' => $table,
            'id' => $id
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request, ItemService $service)
    {
        $service->deleteItem($request['id']);
        $response = [
                    'success' => true,
                    'message' => trans('common.successfully_deleted'),

                ];
         return response()->json($response);
    }

    public function getTranslation()
    {
        $response = [
          'success' => true,
          'message' => trans('item.product_will_be_removed'),
        ];

        return response()->json($response);
    }

    public function updateItem($id, $lang,  ItemService $service)
    {
       return view('admin.items.update_item',
           ['categories' => Taxonomy::with(['translates' => function ($query){
               $query->where('lang', auth()->user()->lang);
           }])->type('item_category')
               ->get(),
               'item' => ItemTranslation::with('categories', 'files')->where('item_id', $id)->where('lang', $lang)->first(),
               'attributes' => Attribute::with('itemAttribute')->where('lang', $lang)->get(),
               'itemAttributes' => ItemAttribute::with('attribute')
                   ->where('item_id', $id)->where('lang', $lang)->get()
           ]);
    }

    public function updateItemStore(CreateOrUpdatePhotoRequest $request, ItemService $service)
    {
        $update = $service->updateItemStore($request);
        return redirect()->route('admin.attributes.item-attributes', [$update[0], $update[1]]);
    }

    public function saveAttachedFiles($id, Request $request, ItemService $service)
    {
        $type = 'photo';
        $save = ModelFilesService::saveOne($request->attached_files, $id, ItemTranslation::class, '', $type);
    }

    public function savePreviewPhoto($id, CreateOrUpdatePhotoRequest $request, ItemService $service)
    {
        $type = 'preview_photo';
        $save = ModelFilesService::saveOne($request->attached_files, $id, ItemTranslation::class, '', $type);
    }

    public function deletePhoto($id, ItemService $service)
    {
        $service->deletePhoto($id);
        return redirect()->back();
    }

    public function addLang($id, $lang)
    {
        return view('admin.items.addLang', ['categories' => Taxonomy::with(['translates' => function ($query){
            $query->where('lang', auth()->user()->lang);
        }])->type('item_category')
            ->get(),
            'item' => ItemTranslation::with('categories', 'files')->where('item_id', $id)->where('lang', $lang)->first(),
            'id' => $id,
            'lang' => $lang,
        ]);
    }

    public function storeLang(CreateOrUpdateItemRequest $request, $id, $lang, ItemService $service)
    {
        $service->saveLang($request, $id, $lang);
        return redirect()->route('admin.items.updateItem', [$id, $lang]);
    }

    public function deleteTranslation($id, $key, ItemService $service)
    {
        $service->deleteTranslation($id, $key);
        return redirect()->back();
    }


}
