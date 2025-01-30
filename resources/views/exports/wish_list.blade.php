<table>
    <thead>
        <tr>
            <th><b>SKU</b></th>
            <th><b>Name</b></th>
            <th><b>Quantity</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        @php
        $product_data = $product["data"];
        @endphp

        <tr>
            <td>{{ $product_data->id }}</td>
            <td>{{ $product_data->title }}</td>
            <td>{{ $product["qty"] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>