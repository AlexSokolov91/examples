@extends('layouts.app')
@section('content')
    <div class="card-header flex-wrap pt-6 pb-0">
        <div class="card-titel">
            <h2 class="card-label"> @if($id != null) @lang('item.update_set')  @else  @lang('item.create_set') @endif </h2>
        </div>
    </div>
        <div class="card-body">
            <div id="kt_repeater_1">
                @if($id == null)
                <div class="form-group row">
                    <form action="{{route('admin.sets.store')}}" method="post">
                        @csrf
                        @include('partials._errors_block')
                        <div class="form-group row product_list col-12">
                        <div class="col-md-4">
                            <label>@lang('common.language'):</label>
                            <select name="language" class="form-control lang" id="lang" value="">
                                <option>@lang('common.select-lang')</option>
                                @foreach(config('estore.content-lang') as $key => $lang)
                                    <option value="{{$key}}">{{$lang}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>@lang('common.product'):</label>
                            <div class="select_for_product"  id="select_for_product">
                                <select  class="form-control"  id="product">
                                    <option>@lang('item.select_product')</option>
                                </select>
                            </div>
                            <div class="d-md-none mb-2"></div>
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
                            <div class="d-md-none mb-2"></div>
                        </div>
                        </div>

                    <div data-repeater-list="sets" class="col-lg-12 repeater">
                        <div data-repeater-item="" class="form-group row align-items-center">
                            <div class="form-group row product_list col-lg-12">
                                <div class="col-md-4">
                                    <label>@lang('common.language'):</label>
                                    <input name="language" readonly class="form-control lang" id="lang" type="text" value="">
                                </div>
                                <div class="col-md-4">
                                    <label>@lang('common.product'):</label>
                                    <div class="select_for_product" id="select_for_product{{uniqid()}}">
                                        <select class="form-control" id="product" >
                                            <option >@lang('item.select_product')</option>
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
                    </form>
                </div>
                @endif
                @if(isset ($id))
                        <div class="form-group row">
                            <form action="{{route('admin.sets.store')}}" method="post" data-value="{{$id}}" class="form">
                                @csrf
                            <div class="form-group row product_list col-lg-12">
                                    <div class="col-md-4">
                                        <label>@lang('common.language'):</label>
                                        <select name="language" class="form-control lang" id="lang">
                                            <option>@lang('common.select-lang')</option>
                                            @foreach(config('estore.content-lang') as $key => $lang)
                                                <option value="{{$key}}">{{$lang}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>@lang('common.product'):</label>
                                        <div class="select_for_product"  id="select_for_product{{uniqid()}}">
                                        <input type="text" class="form-control" readonly   value="">
                                        <div class="d-md-none mb-2"></div>
                                    </div>
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
                                        <div class="d-md-none mb-2"></div>
                                    </div>
                            </div>
                                <div data-repeater-list="sets" class="col-lg-12 repeater">
                                    <div data-repeater-item="" class="form-group row align-items-center">
                                        <div class="form-group row product_list col-lg-12">
                                            <div class="col-md-3">
                                                <label>@lang('common.language'):</label>
                                                <input name="language" readonly class="form-control lang" id="lang" type="text" value="">
                                            </div>
                                            <div class="col-md-2">
                                                <label>@lang('common.product'):</label>
                                                <div class="select_for_product" id="select_for_product{{uniqid()}}" name="product">
                                                    <select class="form-control" id="product">
                                                        <option >@lang('item.select-product')</option>
                                                    </select>
                                                </div>
                                                <div class="d-md-none mb-2"></div>
                                            </div>
                                            <div class="col-md-2">
                                                <label>@lang('item.price_without_set'):</label>
                                                <input readonly class="form-control price" id="price" name="price_without_set" value="">
                                                <div class="d-md-none mb-2"></div>
                                            </div>
                                            <div class="col-md-2">
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
                                        <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary" id="button1">
                                            <i class="la la-plus"></i>@lang('common.add')</a>
                                    </div>
                                </div>
                            <button type="submit" class="btn btn-success">@lang('common.save')</button>
                            </form>
                        </div>
                    @endif
              </div>
            </div>
    @endsection
@section('custom_scripts')
    <script src="{{asset('/js/admin/items/form-repeater.js')}}"></script>
    <script src="{{asset('/js/admin/items/createSets.js')}}"></script>
@endsection
