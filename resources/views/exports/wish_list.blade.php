<table>
    <thead>
        <tr>
            <th><b>SKU</b></th>
            <th><b>Name</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->title }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
