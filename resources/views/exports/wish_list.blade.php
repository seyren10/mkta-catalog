<table>
    <thead>
        <tr>
            <th style="width: 150px; text-align: left;"><b>SKU</b></th>
            <th style="width: 300px; text-align: left;"><b>Name</b></th>
            <th style="width: 70px; text-align: left;"><b>Quantity</b></th>
            <th style="width: 80px; text-align: left;"><b>Volume</b></th>
            <th style="width: 150px; text-align: left;"><b>Total Volume (Metric)</b></th>
            <th style="width: 150px; text-align: left;"><b>Total Volume (Imperial)</b></th>
            <th style="width: 250px; text-align: left;"><b>Link</b></th>
        </tr>
    </thead>
    <tbody>
        @php
            $total_metric = 0;
            $total_imperial = 0;
        @endphp

        @foreach($products as $product)
            @php
                $product_data = $product["data"];
                $metric = $product_data->volume * $product["qty"];
                $imperial = ($product_data->volume * 35.3147) * $product["qty"];

                $total_metric += $metric;
                $total_imperial += $imperial;
            @endphp

            <tr>
                <td>{{ $product_data->id }}</td>
                <td>{{ $product_data->title }}</td>
                <td style="text-align: center;">{{ $product["qty"] }}</td>
                <td style="text-align: center;">{{ $product_data->volume }}</td>
                <td style="text-align: center;">{{ number_format($metric, 2) }}</td>
                <td style="text-align: center;">{{ number_format($imperial, 2) }}</td>
                <td>
                    <a href="{{ url('/catalog/product').$product_data->id }}">
                        {{ url('/catalog/product/').$product_data->id }}
                    </a>
                </td>
            </tr>
        @endforeach

        <tr>
            <td colspan="4" style="font-weight: bold;">Total</td>
            <td style="text-align: center;">{{ number_format($total_metric, 2) }}</td>
            <td style="text-align: center;">{{ number_format($total_imperial, 2) }}</td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>