<?php


namespace App\Services\Admin;

use App\Models\FormGeneration;
use App\Models\FormGenerationData;

class FormGenerationService
{
    public static function generateDataForFormGenerationTable($request)
    {
        $data = [];
        $formGenerations = FormGeneration::all()->unique('form_id');

        foreach ($formGenerations as $form)
        {
            $data[] = [
                 'name' => $form->input_name,
                 'action' => view('admin.form_generation.action', ['id' => $form->form_id])->render()
                ];
        }
        return $data;
    }

    public function store($request)
    {
        $formId = FormGeneration::get('form_id')->last();
        if($formId == null){
            $formId = 1;
        }else{
            $formId = $formId->form_id +1;
        }
        foreach ($request['form'] as $key => $data) {
            $form = new FormGeneration();
            $form->form_id = $formId;
            $form->label = $data['label'];
            $form->input_name = $data['input_name'];
            $form->type = $data['type'];
            $form->position = $data['position'] ?? 0;
            $form->accepted_value = $data['accepted_value'] ?? $request['accepted_value'] ?? $data['type'];
            $form->save();

            if(!empty($data['option'])){
                foreach ($data['option'] as $key => $option){
                    $formOption = new FormGenerationData();
                    $formOption->form_generation_id = $form->id;
                    $formOption->form_id =  $formId;
                    $formOption->option = $option;
                    $formOption->save();
                }
            }
        }
    }

    public function update($request)
    {
      FormGeneration::where('id', $request['id'])->update(['label' => $request['label'],
              'input_name' => $request['input_name'],
              'type' => $request['type'],
              'accepted_value' => $request['accepted_value'],
              'position' => $request['position'] ?? 0
              ]
          );

        foreach ($request['id'] as $key => $id)
        {
            $data = FormGenerationData::find($id);
            $data->update(['option' => $request['option'][$key]]);
             $array = array_diff_key($request['option'], $request['id']);

        }
        foreach ($array as $item)
        {
            $data = new FormGenerationData();
            $data->form_id = $request['form_id'];
            $data->form_generation_id = $request['form_generation_id'];
            $data->option = $item;
            $data->save();
        }
    }

    public function destroy($id)
    {
        $delete = FormGeneration::where('form_id', $id);
        $delete->delete();

        $data = FormGenerationData::where('form_generation_id', $id);
        $data->delete();
    }
}
