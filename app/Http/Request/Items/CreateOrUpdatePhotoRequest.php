<?php


namespace App\Http\Requests\Items;
use App\Models\ModelFile;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdatePhotoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'preview_photo' =>
                function($attribute,$value, $fail)
                {
                    $preview = ModelFile::where('type', 'preview_photo')->where('model_id', $this->item_id)->get();

                    if($preview->count() >= 1){
                        $fail(trans('validation.custom.upload_list_extensions'));
                    }
                },
        ];
    }
}
