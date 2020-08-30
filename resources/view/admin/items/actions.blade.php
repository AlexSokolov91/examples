<div class='btn-group'>
<a class='btn btn-secondary btn-icon' href='{{route('admin.items.updateItem', [$id, $lang])}}'>
    <i class='flaticon-edit'> </i></a>
</div>
<div class='btn-group'>
    <form action='{{route('admin.items.delete.translation', [$id, $lang])}}' method='post'>
            @csrf
        <button type='submit' class='btn btn-secondary btn-icon'>' <i class='flaticon-delete'></i> </button>
    </form>
</div>
<div class="btn-group">
    <a class="" href="{{route('admin.attributes.item-attributes', [$id, $lang])}}"><i class='icon-2x text-dark-50 flaticon-add-circular-button'></i></a>
</div>
