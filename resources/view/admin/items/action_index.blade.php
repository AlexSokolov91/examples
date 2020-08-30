<div class='btn-group'>
    <a class='icon-2x text-dark-50 flaticon-eye' href="{{route('admin.items.edit', $id)}}"></a>
</div>
    <div class='btn-group last'>
        <form action='' data-action="{{route('admin.items.destroy', $id)}}"  data-value="{{$id}}"  class="delete">
            @csrf

            <button type="submit" class="btn btn-secondary btn-icon" id="delete" ><i type="button" class="flaticon-delete" id="delete"></i></button>
        </form>
    </div>

