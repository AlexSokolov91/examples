<div class='btn-group'>
    <a class='icon-2x text-dark-50 flaticon-eye' href="{{route('admin.attributes.edit', $id)}}"></a>
</div>
    <div class='btn-group'>
        <form action='{{route('admin.attributes.destroy', $id)}}' method='post'>
            @csrf
            <button type="submit" class="btn btn-secondary btn-icon" ><i class="flaticon-delete"></i></button>
        </form>
    </div>


