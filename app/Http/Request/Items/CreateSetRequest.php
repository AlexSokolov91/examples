<?php


namespace App\Http\Requests\Items;
use Illuminate\Foundation\Http\FormRequest;

class CreateSetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
                'language' => 'required',
                'firstProduct' => 'required',
                'price_without_set' => function($attribute,$value, $fail)
                {
                  if(!isset($this['sets'])){
                      $fail(trans('validation.not_enough_items_in_set'));
                  }
                },
                'price_with_set' => 'required',
                'sets.*.price_without_set' => 'required',
                'sets.*.price_with_set' => function($attribute,$value, $fail)
                {
                    $count = 1;
                   if(isset($value))
                   {
                       $count ++;
                   }
                    if($count <2){
                        $fail(trans('validation.not_enough_items_in_set'));
                    }
                }
               ];
    }
    public function messages()
    {
        return [
            'language.required' => trans('validation.language_field_is_required'),
            'price_with_set' => trans('validation.the_price_without_set_field_is_required')
        ];
    }
}
