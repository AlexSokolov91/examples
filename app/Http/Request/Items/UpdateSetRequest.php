<?php


namespace App\Http\Requests\Items;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'price_with_set' => function($attribute, $value, $fail)
            {
                $count = 0;
                foreach ($value as $item){
                    if(isset($item)){
                        $count ++;
                    }
                    if (isset($this['sets'][0]['price_with_set'])){
                        $count ++;
                    }
                }
                if($count < 2){
                    $fail(trans('validation.not_enough_items_in_set'));
                }
            },
            'sets.*.price_with_set' => 'required|numeric|min:2|max:9999999',

            ];
    }

}
