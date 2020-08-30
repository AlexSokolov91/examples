@foreach($itemAttributes as $key => $attribute)
<div class='current{{$key}}'>
    <input type='hidden' id='keys' data-value='{{$key}}'>
    <input type='hidden' value='{{$request->id}}' name='attr[{{100 + $key}}][item_id]' class='item_id'>
    <input type='hidden' name='attr[{{100 + $key}}][langKey]' value='{{$request->lang}}'>
    <div  class='form-group row align-items-center'>
        <input type='hidden' name='attr[{{100 + $key}}][attribute_id]' id='attribute_id' value='{{$attribute->attribute_id}}'>
        <div class='col-md-2'>
            <label>@lang('common.name'):</label>
            <input type='text' class='form-control'  value='{{$attribute->attribute->name}}'>
            <div class='d-md-none mb-2'></div>
        </div>
        <div class='col-md-6'>
            <label>@lang('common.value'):</label>
            <input type='text' class='form-control' name='attr[{{100 + $key}}][value]\' value='{{$attribute->value}}'>
            <div class='d-md-none mb-2'></div>
        </div>
        @csrf
        <div class='col-md-2'>
            <br>
            <a href='javascript:;' data-repeater-delete='' data-action='{{route('admin.attributes.deleteItemAttribute', $attribute->id)}}' data-value='{{$attribute->id}}' id='delete'  class='btn btn-sm font-weight-bolder btn-danger'>
                <i class='la la-trash-o'></i>@lang('common.delete')</a>
        </div>
    </div>
</div>
@endforeach
