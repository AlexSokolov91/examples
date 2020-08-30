@extends('layouts.app')
@section('content')
    <div class="card-header flex-wrap pt-6 pb-0">
        <div class="card-title">
            <span class="card-icon">
                	<i class="kt-font-success flaticon2-line-chart"></i>
            </span>
            <h3 class="card-label"> @lang('item.add_attributes')</h3>
        </div>

        <div class="card-toolbar">
            <a href="{{route('admin.attributes.create')}}" class="btn btn-success font-weight-bolder">
                @lang('item.create_attribute')  </a>
        </div>
    </div>
    <br>
    <form action="{{route('admin.attributes.storeItemAttribute', [$id, $lang] )}}" method="post">
        <div class="card-body">
            <div class="form-group row align-items-center" style="justify-content: space-between;">
                <h3>@lang('item.attribute'):</h3>
                <div class="form-inline" >
                    <div class="mr-40"></div>
                    <label class="checkbox">
                        <input type="checkbox" value="1" @if($item->parent == 1) checked @endif name="parent" class="checkbox">
                        <span></span>@lang('item.is_parent')</label>
                    <div class="form-group options" id="options">
                        <select class="form-control options">
                            <option >@lang('item.choice_parent_attribute')</option>
                            @foreach($parentItems as $parent)
                                @if($parent->id != $id and isset($parent->translations[0]->item_id))
                                    <option value="{{$parent->translations[0]->item_id}}" data-lang="{{$lang}}" data-value="{{route('admin.attributes.getParentAttribute', [$id, $lang])}}">{{$parent->translations[0]->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            <br>
            <div id="kt_repeater_1">
                @include('partials._errors_block')
                @csrf
                @csrf
                @if($attributes->count() < 1)
                    <input class="form-control" value="@lang('item.no_attributes')">
                @endif
                @if($attributes->count() > 0)
                    <div class="block">
                        <input type="hidden" name="langKey" value="{{$lang}}">
                        <input type="hidden" value="{{$id}}" name="item_id" class="item_id">
                        @foreach($itemAttributes as $key => $attribute)
                            <div class="current{{$key}}">
                                <input type="hidden" id="keys" data-value="{{$key}}">
                                <input type="hidden" value="{{$id}}" name="attr[{{100 + $key}}][item_id]" class="item_id">
                                <input type="hidden" name="attr[{{100 + $key}}][langKey]" value="{{$lang}}">
                                <div  class="form-group row align-items-center">
                                    <input type="hidden" name="attr[{{100 + $key}}][attribute_id]" id="attribute_id" value="{{$attribute->attribute_id}}">
                                    <div class="col-md-2">
                                        <label>@lang('common.name'):</label>
                                        <input type="text" class="form-control"  value="{{$attribute->attribute->name}}">
                                        <div class="d-md-none mb-2"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>@lang('common.value'):</label>
                                        <input type="text" class="form-control" name="attr[{{100 + $key}}][value]" value="{{$attribute->value}}">
                                        <div class="d-md-none mb-2"></div>
                                    </div>
                                    @csrf
                                    <div class="col-md-2">
                                        <br>
                                        <a href="javascript:;" data-repeater-delete="" data-action="{{route('admin.attributes.deleteItemAttribute', $attribute->id)}}" data-value="{{$attribute->id}}" id="delete"  class="btn btn-sm font-weight-bolder btn-danger">
                                            <i class="la la-trash-o"></i>@lang('common.delete')</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div data-repeater-list="attr">
                    <div data-repeater-item="" class="form-group row align-items-center" >
                        @if(!empty($attribute))
                            <input type="hidden" value="{{$id}}" name="item_id" class="item_id">
                            <input type="hidden" name="langKey" value="{{$lang}}">
                            <input type="hidden" name="attribute_id" id="attribute_id" value="{{$attribute->attribute_id}}">
                        @endif
                        <div class="col-md-2">
                            <label>@lang('common.name'):</label>
                            <select class="form-control" name="attribute_id">
                                @foreach($attributes as $attribute)
                                    <option name="attribute_id" value="{{$attribute->id}}">
                                        {{$attribute->name}}
                                    </option>
                                @endforeach
                            </select>
                            <div class="d-md-none mb-2"></div>
                        </div>
                        <div class="col-md-6">
                            <label>@lang('common.value'):</label>
                            <input type="text" class="form-control" name="value" value="">
                            <div class="d-md-none mb-2"></div>
                        </div>
                        <div class="col-md-2">
                            <br>
                            <a href="javascript:;" data-repeater-delete="" id="delete"  class="btn btn-sm font-weight-bolder btn-light-danger">
                                <i class="la la-trash-o"></i>@lang('common.delete')</a>
                        </div>
                    </div>
                </div>
                <label class="col-lg-2 col-form-label text-right"></label>

                <div class="col-lg-4">
                    <a href="javascript:;" data-repeater-create=""  class="btn btn-sm font-weight-bolder btn-light-primary">
                        <i class="la la-plus"></i>@lang('common.add')</a>
                </div>
                <br>
                <button type="submit" class="btn btn-success">@lang('common.save')</button>
            </div>
        </div>
    </form>
@endsection
@section('custom_scripts')
    <script src="{{asset('/js/admin/items/form-repeater.js')}}"></script>
    <script src="{{asset('/js/admin/items/getAttribute.js')}}"></script>
    <script src="{{asset('/js/admin/items/deleteAttribute.js')}}"></script>
@endsection
