<div class='btn-group'>
    <a class='btn btn-secondary btn-icon' href='{{route('admin.form-generation.edit', $id)}}'>
        <i class='flaticon-edit'> </i></a>
</div>
<div class='btn-group'>
    <form action='{{route('admin.form-generation.destroy', $id)}}' method='post'>
        @csrf
        <button type='submit' class='btn btn-secondary btn-icon'>' <i class='flaticon-delete'></i> </button>
    </form>
</div>
