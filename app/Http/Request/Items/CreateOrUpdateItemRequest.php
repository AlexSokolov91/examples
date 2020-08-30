<?php

namespace App\Http\Requests\Items;
use App\Models\Attribute;
use App\Models\ModelFile;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateItemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'price' => 'required|numeric',
            'lang' => 'required',
            'currency' => 'required',
            'description' => 'required',
            'short_description' => 'required|max:255',
            'category_id' => 'required',
            'attr' => function($attribute,$value, $fail)
            {
                $uniqueValue = [];
                $attributeCount = 0;
                foreach ($value as $key => $item)
                {
                    $count = Attribute::where('lang', $this->langKey)->get()->count();
                    $attributeCount ++;
                    if($attributeCount > $count){
                        $fail(trans('validation.product attributes cannot be more than existing attributes'));

                    }

                    if($item['attribute_id'] == null or $item['value'] == null){
                        $fail(trans('validation.the_attribute_value_must_not_be_empty'));
                    }
                }
            }
        ];
    }

}
