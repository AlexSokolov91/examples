@extends('layouts.app')
@section('content')
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">@lang('item.item')</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{route('admin.items.create')}}" class="btn btn-primary font-weight-bolder">@lang('item.create_item')</a>
                <div class="mr-5"></div>
                    <a href="{{route('admin.attributes.attributes.index')}}" class="btn btn-success font-weight-bolder">@lang('item.attribute')</a>
                <div class="mr-5"></div><a href="{{route('admin.sets.index')}}" class="btn btn-success font-weight-bolder">@lang('item.sets')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded" id="kt_datatable">
                {!! $table->render() !!}
            </div>
        </div>
        @endsection
@section('custom_scripts')
    <script src="{{asset('/js/admin/items/deleteItem.js')}}"></script>
@endsection
