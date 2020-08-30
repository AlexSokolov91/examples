<br>
<label>@lang('form_generation.accepted_value')</label>
<select name="accepted_value" class="form-control">
     <option>@lang('common.select-placeholder')</option>
    @foreach(config('estore.accepted-value') as $value)
    <option value="{{$value}}">{{$value}}</option>
        @endforeach
</select>
