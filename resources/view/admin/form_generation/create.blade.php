@extends('layouts.app')
@section('content')
    <div class="card-header flex-wrap pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">@lang('form_generation.create_form')</h3>
        </div>
    </div>
    <div class="card-body">
        <form action="{{route('admin.form-generation.store')}}" method="post" class="sendForm">
            @csrf
        <div id="kt_repeater_1">
            @include('partials._errors_block')
            <div class="form-group row">
                <div data-repeater-list="form" class="col-lg-12">
                    <div data-repeater-item="" class="form-group row align-items-center this">
                        <div class="col-md-3">
                            <label>@lang('form_generation.label'):</label>
                            <input type="text" class="form-control forLabel" name="label">
                            <div class="d-md-none mb-2"></div>
                        </div>
                        <div class="col-md-3">
                            <label>@lang('common.name')</label>
                            <input type="text" class="form-control" name="input_name">
                            <div class="d-md-none mb-2"></div>
                        </div>
                        <div class="col-md-3">
                            <label>@lang('form_generation.input_type')</label>
                            <select class="form-control form" name="type">
                                 <option>@lang('common.select-placeholder')</option>
                                @foreach(config('estore.input-type') as $input)
                                    <option value="{{$input}}" name="type">{{$input}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <br>
                            <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
                                <i class="la la-trash-o"></i>Delete</a>
                        </div>
                        <div class="col-md-3 accepted">

                        </div>
                        <div class="col-md-12">
                            <br>
                            <div class="form-repeater">

                            </div>
                          </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4">
                    <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary create">
                        <i class="la la-plus"></i>@lang('common.add')</a>
                </div>
            </div>
                <button type="submit" class="btn btn-success">@lang('common.save')</button>
        </div>
        </form>
    </div>
    @endsection
@section('custom_scripts')
    <script src="{{asset('/js/admin/form_generations/create.js')}}"></script>
    <script src="{{asset('/js/admin/items/form-repeater.js')}}"></script>
@endsection
