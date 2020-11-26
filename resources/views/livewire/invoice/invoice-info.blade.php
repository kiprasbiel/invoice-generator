<tr class="{{ $display }}">
    <td>
        <h5>Produktai</h5>
        @if(isset($items))
            @foreach($items as $item)
                <div class="full-width">
                    {{ $item->name }} {{ $item->price }}
                </div>
            @endforeach
        @endif
    </td>
</tr>
