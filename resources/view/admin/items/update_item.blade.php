@extends('layouts.app')
@section('content')
    <div class="card-header">
        <div class="card-title">
            <div class="card-label">
                <h2>@lang('item.add_photo') </h2>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{route('admin.items.updateItemStore')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('partials._errors_block')
            <div id="kt_repeater_1">
                <div class="form-group row">
                    <input type="hidden" name="item_id" value="{{$item->item_id}}" >
                    <input type="hidden" name="langKey" value="{{$item->lang}}">
                    <div class="form-group col-md-10">
                        <br>
                        <label for="attached_files">@lang('item.attach_preview_photo') </label>
                        <div class="custom-file">
                            <label class="custom-file-label" for="attached_files">@lang('item.choose_files')</label>
                            <input type="file" class="custom-file-input" name="preview_photo" id="attached_files"
                                   data-action="{{route('admin.items.savePreviewPhoto', $item->item_id)}}"
                                   multiple="">
                        </div>
                    </div>
                    <div class=" col-md-3 preview">

                    </div>
                    <div class="col-12"></div>
                    <div class="col-md-12">
                        <span>@lang('item.attach_photo')</span>
                        <div class="col-12"></div>
                        <div class="form-group row">
                            <div class="kt-dropzone dropzone m-dropzone--primary" action="{{route('admin.items.attach_files', $item->item_id)}}" id="k-dropzone-two">
                                <div class="kt-dropzone__msg dz-message needsclick">
                                    <h3 class="kt-dropzone__msg-title">@lang('tickets.drop_or_choose')</h3>
                                </div>
                            </div>
                        </div>
                        <input type = 'hidden' name ='files_ids' id = 'files_id'>
                    </div>
                </div>
                <div class="col-md-4">
                    <br> <br>
                    <button type="submit" class="btn btn-success">@lang('common.save')</button>
                </div>
            </div>
        </form>

        <br> <br>
        @if(!empty($item->files))
            <div class="row">
                @foreach($item->files as $file)
                    <div class="col-lg-2">
                        @if($file->type == 'preview_photo')
                            <div class="card-header">@lang('item.preview_photo')</div>
                        @else
                            <div class="card-header">@lang('item.photo')</div>
                        @endif
                        <div class="card card-custom overlay">
                            <div class="card-body p-0">
                                <div class="overlay-wrapper">
                                    <img src="{{asset('storage/' . $file->file_path)}}" alt="" class="w-100 rounded">
                                </div>
                                <form action="{{route('admin.items.deletePhoto', $file->id)}}" method="post">
                                    @csrf
                                    <div class="overlay-layer">
                                        <button type="submit" class="btn font-weight-bold btn-danger btn-shadow">@lang('common.delete')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
    </div>
    @endif
@endsection
@section('custom_scripts')
    <script src="{{asset('/js/admin/items/update_item.js')}}"></script>
    <script src="{{asset('/js/admin/items/form-repeater.js')}}"></script>
    <script src="{{asset('/js/admin/items/deleteAttribute.js')}}"></script>
@endsection


