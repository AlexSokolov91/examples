<?php


namespace App\Repositories\Admin;


use App\Models\FormGeneration;
use Illuminate\Http\Request;


class FormGenerationRepository
{
    public static function getTableData(Request $request)
    {

       $formGeneration = FormGeneration::all()->unique('form_id');

       $recordsFiltered = $formGeneration->count();

        if (!empty($request->start))
        {
            $formGeneration = $formGeneration->skip($request->start);
        }

        $formGeneration = $formGeneration->take($request->length);

        return [
            'data' => $formGeneration,
            'recordsFiltered' => $recordsFiltered,
        ];
    }
}
