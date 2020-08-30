<?php

namespace App\Http\Controllers\Admin;

use App\Classes\DataTableHelper\DataTableHelper;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormGenerations\FormGenerationEditRequest;
use App\Http\Requests\FormGenerations\FormGenerationRequest;
use App\Models\FormGeneration;
use App\Models\FormGenerationData;
use App\Repositories\Admin\FormGenerationRepository;
use App\Services\Admin\FormGenerationService;
use App\Services\DataTableService;
use Illuminate\Http\Request;

class FormsGenerationController extends Controller
{
    public function index(Request $request)
    {
        $columns = [
            trans('items.items_files') => [
                trans('common.name'),
                trans('common.action'),
            ]
          ];

        $table = new DataTableHelper(route('admin.form-generation.getData'), $columns, [
            'id'               => 'form_generation',
            'ordering'         => false,
            'perPage'          => 10,
            'filtersPerRow' => 3,
            'showFilterButton' => true,
            'scriptOptions'    => [
                'columnDefs' => [
                    ['targets' => '"_all"', 'className' => '"text-center"',],
                ],
                    'columns' => [
                        ['data' => '"name"'],
                        ['data' => '"action"']
                    ]

            ],
        ]);
        return view('admin.form_generation.index', ['table' => $table]);
    }

    public function getData(Request $request)
    {
        $formData = FormGenerationRepository::getTableData($request);
        $formData['data'] = FormGenerationService::generateDataForFormGenerationTable($formData['data']);
        $formData['query'] = DataTableService::createQuery($request);
        return $formData;
    }

    public function create()
    {
     return view('admin.form_generation.create');
    }

    public function getFormType(Request $request)
    {
       if($request['value'] == 'multiple' or $request['value'] == 'select'){
           $render = view('admin.form_generation.render.form_render', ['request' => $request['value']])->render();
           $response = [
               'success' => true,
               'render' => $render,
           ];
       }else{
           $select = view('admin.form_generation.render.accepted_value')->render();
           $response = [
               'success' => false,
               'render' => $select,
           ];
       }
        return response()->json($response);
    }

    public function store(FormGenerationRequest $request, FormGenerationService $service)
    {
        $service->store($request->all());
        return redirect()->route('admin.form-generation.index');
    }

    public function edit($id)
    {
        return view('admin.form_generation.edit', ['formData' => FormGeneration::with('data')->where('form_id', $id)->get(),
            'id' => $id
            ]);
    }

    public function destroy($id, FormGenerationService $service)
    {
        $service->destroy($id);
        return redirect()->route('admin.form-generation.index');
    }

    public function update(Request $request, FormGenerationService $service)
    {
        $service->update($request->all());
        return redirect()->route('admin.form-generation.index');
    }

    public function action(Request $request)
    {

    }

    public function deleteOption(FormGenerationEditRequest $request)
    {
        if(isset($request->id)) {
            $delete = FormGenerationData::find($request['id']);
            $delete->delete();
            $response = [
                'success' => 'true'
            ];
        }

        return response()->json($response);
    }

}
