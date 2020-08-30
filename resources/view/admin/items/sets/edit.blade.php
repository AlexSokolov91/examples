@extends('layouts.app')
@section('content')
    <div class="card-header flex-wrap pt-6 pb-0">
        <div class="card-titel">
            <h2 class="card-label">  @lang('item.edit_set')  </h2>
        </div>
    </div>
    <div class="card-body">
        @include('partials._errors_block')
        <div class="form-group row">
            @foreach($sets as $set)
                 <form action="{{route('admin.sets.update', $id)}}" method="post">
                        @csrf
                        <div class="form-group row product_list{{$set->id}} col-12">
                            <div class="col-md-4">
                                <label>@lang('common.language'):</label>
                                <input type="text" class="form-control lang" readonly name="lang" @foreach(config('estore.content-lang') as $key => $lang)
                                 @if($key == $set->lang) value="{{$lang}}" @endif @endforeach data-value="{{$set->lang}}">

                            </div>
                            <div class="col-md-4">
                                <label>@lang('common.product'):</label>
                                <input type="text" class="form-control"  readonly value="{{$set->item_name}}">
                                <div class="d-md-none mb-2"></div>
                            </div>
                            <div class="col-12"></div>
                            <br>
                            <div class="col-md-4">
                                <label>@lang('item.price_without_set'):</label>
                                <input readonly class="form-control price" id="price"  value="{{$set->price_without_set}}">
                                <div class="d-md-none mb-2"></div>
                            </div>
                            <div class="col-md-4">
                                <label>@lang('item.price_with_set'):</label>
                                <input  class="form-control" name="price_with_set[{{$set->id}}]" value="{{$set->price_with_set}}">
                                <div class="d-md-none mb-2"></div>
                            </div>
                            <div class="col-md-2">
                                <br>
                                <a href="javascript:;" data-repeater-delete="" id="delete" data-value="{{$set->id}}" class="btn btn-sm font-weight-bolder btn-light-danger">
                                    <i class="la la-trash-o"></i>Delete</a>
                            </div>
                        </div>
                    @endforeach
                <div id="kt_repeater_1">
                        <div data-repeater-list="sets" class="col-lg-12 repeater">
                            <div data-repeater-item="" class="form-group row align-items-center">
                                <div class="form-group row col-lg-12 product_list" id="product_list">
                                    <div class="col-md-4">
                                        <label>@lang('common.language'):</label>
                                        <input name="language" readonly class="form-control lang_repeater" id="lang" type="text" value="">
                                    </div>
                                    <div class="col-md-4">
                                        <label>@lang('common.product'):</label>
                                        <div class="select_for_product">
                                            <select class="form-control" id="product" name="product">
                                                <option>@lang('item.select-product')</option>
                                            </select>
                                        </div>
                                        <div class="d-md-none mb-4"></div>
                                    </div>
                                    <div class="col-12"></div>
                                    <br>
                                    <div class="col-md-4">
                                        <label>@lang('item.price_without_set'):</label>
                                        <input readonly class="form-control price" id="price" name="price_without_set" value="">
                                        <div class="d-md-none mb-2"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>@lang('item.price_with_set'):</label>
                                        <input  class="form-control" name="price_with_set">
                                        <div class="d-md-none mb-3"></div>
                                    </div>
                                    <div class="col-md-2">
                                        <br>
                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
                                            <i class="la la-trash-o"></i>Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary" id="button">
                                    <i class="la la-plus"></i>@lang('common.add')</a>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">@lang('common.save')</button>
                </div>
                </form>
             </div>
          </div>
    @endsection
@section('custom_scripts')
    <script src="{{asset('/js/admin/items/form-repeater.js')}}"></script>
    <script src="{{asset('/js/admin/items/editSet.js')}}"></script>
    @endsection
