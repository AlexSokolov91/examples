@extends('layouts.app')
@section('content')
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">@lang('item.edit_item')</h3>
            </div>
        </div>
        <div class="card-body">
            {!! $table->render() !!}
        </div>
        @endsection
