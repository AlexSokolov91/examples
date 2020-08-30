
<select class="form-control product" name="product" id="product">
        <option>
            @lang('item.select_product')
        </option>
       @if($items->count() > 0)
        @foreach($items as $item)
        <option  value="{{$item->item_id}}" >
            {{$item->name}}

        </option>
        @endforeach
           @endif
    </select>

