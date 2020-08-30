@extends('layouts.app')
@section('content')
    <div class="card-header">
        <div class="card-title">
           <h3> @lang('item.create_attribute') </h3>
        </div>
    </div>
    <div class="card-body">
        <form action="{{route('admin.attributes.store')}}" method="post">
            @csrf
            @include('partials._errors_block')
            @foreach(config('estore.content-lang') as $key => $lang)
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>@lang('common.language'):</label>
                        <input type="text" class="form-control"  value="{{$lang}}" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label>@lang('common.value'):</label>
                        <input type="text" class="form-control" name="name[{{$key}}]">
                    </div>
                </div>
            @endforeach
            <button type="submit" class="btn btn-success">@lang('common.save')</button>
        </form>
    </div>
    @endsection

