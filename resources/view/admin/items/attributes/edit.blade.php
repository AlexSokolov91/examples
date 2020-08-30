@extends('layouts.app')
@section('content')
    <div class="card-header">
        <div class="card-title">
            <h3> @lang('item.create_edit') </h3>
        </div>
    </div>
    <div class="card-body">
        <form action="{{route('admin.attributes.update', $id)}}" method="post">
            @csrf
            @include('partials._errors_block')
            @foreach($attributes as  $attribute)
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>@lang('common.language'):</label>
                        <input type="text" class="form-control" @foreach(config('estore.content-lang') as $key => $value)@if($attribute->lang == $key) value="{{$value}}" @endif @endforeach  readonly>
                    </div>
                    <div class="col-lg-6">
                        <label>@lang('common.value'):</label>
                        <input type="text" class="form-control" name="name[{{$attribute->lang}}]" value="{{$attribute->name}}">
                    </div>
                </div>
            @endforeach
            <button type="submit" class="btn btn-success">@lang('common.save')</button>
        </form>
    </div>
@endsection
