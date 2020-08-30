<?php
namespace App\Http\Requests\FormGenerations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormGenerationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'form.*.input_name' => 'required',
            'form.*.type' => 'required',
            'form.*.option' => function($attribute,$value, $fail){
                $count = 0;
                if(gettype($value) != 'string') {
                    foreach ($value as $item) {

                        if (isset($item)) {
                            $count++;
                        }
                    }
                }else{
                    $count++;
                }
                if($count < 2){
                 $fail(trans('form_generation.values_must_be_more_than_one'));
                }

            },
            ];
    }
}
