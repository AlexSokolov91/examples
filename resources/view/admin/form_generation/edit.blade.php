@extends('layouts.app')
@section('content')
    <div class="card-header flex-wrap pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">@lang('form_generation.edit_form')</h3>
        </div>
    </div>
    <div class="card-body">
        <form action="{{route('admin.form-generation.update', $id)}}" method="post" class="sendForm">
            @csrf
            <div id="kt_repeater_1">
                @include('partials._errors_block')
                <div class="form-group row">
                    <input type="hidden" name="id" value="{{$id}}">
                    <div data-repeater-list="form" class="col-lg-12">
                            @foreach($formData as $data)
                                <input type="hidden" name="input_id[]" value="{{$data->id}}">
                            <div data-repeater-item="" class="form-group row align-items-center this">
                                <div class="col-md-3">
                                    <label>@lang('form_generation.label'):</label>
                                    <input type="text" class="form-control forLabel" name="label[{{$data->id}}]" value="{{$data->label}}">
                                    <div class="d-md-none mb-2"></div>
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('common.name')</label>
                                    <input type="text" class="form-control" name="input_name[{{$data->id}}]" value="{{$data->input_name}}">
                                    <div class="d-md-none mb-2"></div>
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('form_generation.input_type')</label>
                                    <input class="form-control" name="type[{{$data->id}}]" value="{{$data->type}}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
                                        <i class="la la-trash-o"></i>Delete</a>
                                </div>
                                @if($data->data->count() == 0)
                                    <div class="col-md-3 accepted">
                                        <br>
                                        <label>@lang('form_generation.accepted_value')</label>
                                        <select name="accepted_value" class="form-control">
                                            <option>{{$data->accepted_value}}</option>
                                            @foreach(config('estore.accepted-value') as $value)
                                                @if($data->accepted_value != $value)
                                                    <option value="{{$value}}">{{$value}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="col-md-12">
                                    <br>
                                        <div class="form-repeater">
                                            <div class="kt_repeater_1">
                                                <label>@lang('form_generation.option_value')</label>
                                                @foreach($data->data as $value)
                                                    <input type="hidden" name="form_id" value="{{$value->form_id}}">
                                                    <input type="hidden" name="id[]" value="{{$value->id}}">
                                                  <input type="hidden" name="form_generation_id" class="hidden" value="{{$value->form_generation_id}}">
                                                    <div class="col-lg-10 selectOption">
                                                        <div class="form-group row align-items-center">
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" name="option[]" value="{{$value->option}}">
                                                            </div>
                                                            <div class="input-group-append">
                                                                <a href="javascript:;"  class="btn font-weight-bold btn-danger btn-icon deleteOption" id="delete" data-action="{{route('admin.form-generation.deleteOption', $value->id)}}" data-value="{{$value->id}}" data-id="{{$value->form_id}}">
                                                                    <i class="la la-close"></i>
                                                                </a>
                                                            </div>
                                                            <div class="mr-5"></div>
                                                            <div class="input-group-append">
                                                                <a class="btn font-weight-bold btn-success btn-icon add">
                                                                    <i class="la la-plus"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <br>
                                        </div>
                                </div>
                            </div>
                            @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-success">@lang('common.save')</button>
            </div>
        </form>
    </div>
@endsection
@section('custom_scripts')
    <script src="{{asset('/js/admin/form_generations/edit.js')}}"></script>
@endsection
