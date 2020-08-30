<?php


namespace App\Http\Requests\FormGenerations;

use App\Models\FormGenerationData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormGenerationEditRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'formId' => function($attribute,$value, $fail){
                $count = 0;
                $options = FormGenerationData::where('form_id', $this->formId)->get();
                foreach ($options as $option)
                {
                    if(isset($option))
                    {
                        $count ++;
                    }
                }
                if($count <= 2){
                    $fail(trans('form_generation.options_must_be_more_than_one'));
                }
            }
        ];
    }
}
