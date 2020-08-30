@extends('layouts.app')
@section('content')
    <div class="card-body">
        <form action="{{route('admin.items.store.lang', [$id, $lang])}}" method="POST">
            @csrf
            <div id="kt_repeater_1">
                @include('partials._errors_block')
                <div class="form-group row">
                    <div class="col-md-3">
                        <label>@lang('common.name')*:</label>
                        <input type="text" name="name" class="form-control" value="">
                        <div class="d-md-none mb-2"></div>
                    </div>
                    <div class="col-md-2">
                        <label>@lang('common.language')*: </label>
                        <select name="lang" class="form-control select_2_init"  required data-ajax-url="">
                            @foreach(config('estore.content-lang') as $key => $language)
                                @if($lang == $key)
                                    <option value="{{$key}}">{{$language}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>@lang('common.currency')*: </label>
                        <select name="currency" class="form-control select_2_init"  required data-ajax-url="">
                            @foreach(config('estore.currency') as $key => $currency)
                                <option value="{{$key}}">{{$currency}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>@lang('common.price')*:</label>
                        <input type="text" name="price"  class="form-control">
                        <div class="d-md-none mb-2"></div>
                    </div>
                    <div class="col-md-2">
                        <br>
                        <div class="radio-inline">
                            <label class="checkbox checkbox-success">
                                <input value="1" name="is_active" @if(@old('is_active') != null) checked @endif type="checkbox">@lang('common.active')
                                <span></span></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <br>
                        <label>@lang('common.description')*:</label>
                        <textarea type="text"  name="description" class="form-control" value="{{@old('description')}}"  rows="3" cols="50"> </textarea>
                        <div class="d-md-none mb-2"></div>
                    </div>
                    <div class="col-md-4">
                        <br>
                        <label>@lang('common.short_description'):</label>
                        <textarea type="text"  name="short_description" class="form-control" value="{{@old('short_description')}}" rows="3" cols="50"> </textarea>
                        <div class="d-md-none mb-2"></div>
                    </div>
                    <div class="col-md-4">
                        <br>
                        <label>@lang('common.category')*:</label>
                        <div class="dropdown bootstrap-select show-tick form-control">
                            <select class="form-control selectpicker" multiple tabindex="null" name="category_id[]">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->translates[0]->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-md-none mb-2"></div>
                    </div>
                    <div class="col-12"></div>
                    <div class="col-md-4">
                        <br> <br>
                        <button type="submit" class="btn btn-success">@lang('common.save')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('custom_scripts')
    <script src="{{asset('/js/admin/items/form-repeater.js')}}"></script>
@endsection
