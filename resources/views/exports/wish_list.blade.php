<table>
    <thead>
        <tr>
            <th>SKU</th>
            <th>Name</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->title }}</td>
                <td>{{ $product->description }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
