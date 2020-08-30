@extends('layouts.app')

@section('content')
    <div class="card-header flex-wrap py-3">
        <div class="card-title">
            <h3 class="card-label">@lang('item.sets')</h3>
        </div>
        <div class="card-toolbar">
            <a href="{{route('admin.sets.create')}}" class="btn btn-success font-weight-bolder">@lang('item.create_set')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded" id="kt_datatable">
            {!! $table->render() !!}
        </div>
    </div>

    @endsection
