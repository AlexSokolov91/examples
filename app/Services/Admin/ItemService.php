<?php


namespace App\Services\Admin;


use App\Classes\DataTableHelper\DataTableHelper;
use App\Classes\DataTableHelper\Filter\SelectFilter;
use App\Item;
use App\ItemCategory;
use App\ItemPrice;
use App\ItemTranslation;
use App\Models\Attribute;
use App\Models\ItemAttribute;
use App\Models\Items\ItemSet;
use App\Models\ModelFile;
use App\Models\Taxonomy;
use App\Repositories\Admin\ItemRepository;
use App\Services\ModelFilesService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Symfony\Component\HttpFoundation\Request;
use Carbon\Carbon;
class ItemService
{
    public static function generateItemsTable($request = null): DataTableHelper
    {
        $columns = [
            trans('items.items_files') => [
                trans('common.image'),
                trans('common.name'),
                trans('common.action'),
            ]
        ];

        $data = self::generateDataForItemsTable($request);

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

        return $table;
    }

    public static function generateDataForItemsTable($request) :array
    {
        $data = [];
        $items = Item::with('translations', 'categories')->get();
        $image = '';
        foreach ($items as $item)
        {
            $image = ModelFile::where('model_id', $item->id)->where('type', 'preview_photo')->first();
            if($image['file_path'] != null) {
                $image = "http://estore-alx.badvps.com/storage/" . $image['file_path'];
            }else{
                $image = "http://estore-alx.badvps.com/storage/default.jpg";
            }
            $name = ItemTranslation::where('item_id', $item->id)->value('name');
            $action = route('admin.items.edit', $item->id);
                    $data[] = [
                        'image' => "<img src='$image' height='40px'>",
                        'name' => $name,
                        'action' =>  view('admin.items.action_index', ['id' => $item->id])->render(),
                    ];
        }
            return $data;
    }

    public static function generateEditTable($id): DataTableHelper
    {
        $columns = [
            trans('items.items_files') => [
                trans('common.name'),
                trans('common.status'),
                trans('common.action'),
            ]
        ];

        $data = self::generateDataEditTable($id);
        $table = new DataTableHelper($data, $columns, [
            'id' => 'item',
            'ordering' => false,
            "showVisibilityColumnsButton" => false,
            'scriptOptions' => [
                'paging' => false,
                'columnDefs' => [
                    ['targets' => '"_all"', 'className' => '"text-center"']
                ],
                'columns' => [
                    ['data' => '"name"'],
                    ['data' => '"status"'],
                    ['data' => '"action"']
                ]
            ]
        ]);
        return $table;
    }


    private static function generateDataEditTable($id)
    {
        $items = Item::with('translations')->find($id);


        $data = [];
        $status = '';
        foreach (config('estore.content-lang') as $key => $lang) {
             $item = ItemTranslation::where('item_id', $id)->where('lang', $key)->first();
            if(isset($item)){
               $action = view('admin.items.actions', ['id' => $id, 'lang' => $key])->render();
            }else{
                $route = route('admin.items.addLang', [$id, $key]);
                $action = "<a class='btn btn-secondary btn-icon' href='$route'>
                    <i class='icon-2x text-dark-50 flaticon2-plus'></i>";
            }

            $data[] = [
                'name' => $lang,
                'status' => $status,
                'action' => $action,
                      ];
        }
        return $data;

    }

    public function saveItem($request)
    {
        $item = new Item();
        $item->save();
        if(isset($item)){
            $translation = new ItemTranslation();

            $translation->item_id = $item->id;
            $translation->name = $request->name;
            $translation->description = $request->description;
            $translation->short_description = $request->short_description;
            $translation->is_active = $request->is_active ?? 0;
            $translation->lang = $request->lang;
            $translation->currency = $request->currency;
            $translation->price = $request->price;
            $translation->save();

          foreach ($request->category_id as $category) {
            $categories = new ItemCategory();
            $categories->item_id = $item->id;
            $categories->category_id = $category;
            $categories->save();
          }

    }
        $item->load("translations");
        return $item;
    }

    public function updateItemStore($request)
    {
        $update = ItemTranslation::where('item_id', $request['item_id'])->where('lang', $request['langKey'])->first();

        if(isset($request['preview_photo'])){
            $format = strstr($request['preview_photo'], '.');
            $format1 = trim($format, ".");
            $type = 'preview_photo';
            $save = ModelFilesService::saveOne($request['preview_photo'], $request['item_id'], ItemTranslation::class, '', $type);
        }
            if(isset($request->attr)) {
                foreach ($request->attr as $attribute) {
                    $attr = new ItemAttribute();
                    $attr->item_id = $request['item_id'];
                    $attr->attribute_id = $attribute['attr_id'];
                    $attr->value = $attribute['value'];
                    $attr->lang = $request['langKey'];
                    $attr->save();
                }
            }
        return [$request['item_id'], $request['langKey']];
    }

    public function deletePhoto($id)
    {
        $delete = ModelFile::find($id);
        $delete->delete();
    }

    public function saveLang(Request $request, $id, $lang)
    {
        $item = Item::find($id);
        $item->update(['created_at' => Carbon::now()]);
        if(isset($item)){
            $translation = new ItemTranslation();

            $translation->item_id = $item->id;
            $translation->name = $request->name;
            $translation->description = $request->description;
            $translation->short_description = $request->short_description;
            $translation->is_active = $request->is_active ?? 0;
            $translation->lang = $request->lang;
            $translation->currency = $request->currency;
            $translation->price = $request->price;
            $translation->save();

            foreach ($request->category_id as $category)
            {
                $categories = new ItemCategory();
                $categories->item_id = $item->id;
                $categories->category_id = $category;
                $categories->save();
            }
        }
        $item->load("translations");
        return $item;
    }

    public function deleteTranslation($id, $key)
    {
       $translation = ItemTranslation::where('item_id', $id)->where('lang', $key);
       $translation->delete();
    }

    public function deleteItem($id)
    {
       $item = Item::find($id);
       $item->delete();

       $translation = ItemTranslation::where('item_id', $id)->delete();
       $categories = ItemCategory::where('item_id', $id)->delete();
       $photo = ModelFile::where('model_id', $id)->delete();
       $sets = ItemSet::where('item_id', $id)->delete();
    }
}
