<?php


namespace App\Http\Requests\Items;
use App\Models\ItemAttribute;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateAttributeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

                'name' => function($attribute,$value, $fail)
                {
                    foreach ($value as $item)
                    {
                        if($item == null){
                            $fail(trans('validation.all_fields_are_required'));
                        }
                    }
                },
                'attr' => function($attribute,$value, $fail){
                foreach ($value as $key => $item){
                    if($item['attribute_id'] == $this['attribute_id']){
                        $fail(trans('item.there_can_be_no_two_identical_attributes'));
                    }
                   $attr[] = $item['attribute_id'];
                    $array_cu = array_unique($attr);
                    if (count($attr) > count( $array_cu )) {
                        $fail(trans('item.there_can_be_no_two_identical_attributes'));
                    }

                    if($item['attribute_id'] == null){
                        $fail(trans('item.attribute_can_not_be_empty'));
                    }
                }
               },
            'attr.*.value' => function($attribute,$value, $fail){
               if($value == null){
                   $fail(trans('validation.all_fields_are_required'));
               }
            },

               ];
    }

    public function messages()
    {
        return [
            'value.required' => trans('validation.all_fields_are_required'),

        ];
    }

}
