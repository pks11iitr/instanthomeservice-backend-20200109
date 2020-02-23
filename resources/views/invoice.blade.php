<html>
<head>

    <style type="text/css" media="all">
        .text-center {text-align: center;}
        .fw600 {font-weight: 600;}
        .mb8 {margin-bottom: 8px;}
        .default-list-upper-alpha {
            list-style-type: upper-alpha;
            list-style-position: inside;
            margin-left: 8px;
        }
    </style>

</head>

<body>

        <h1 class="text-center fw600">Instant Home Service</h1>
        <h3 class="fw600">Order Invoice: {{$order->order_id}}</h3>
        <table class="text-center">
            <tr>
                <th>Item Name</th><th>Quantity</th><th>Price</th>
            </tr>
            @foreach($order->details as $d)
            <tr>
                <td>{{$d->product->category->title.'('.$d->product->name.')'}}</td>
                <td>{{$d->quantity}}</td>
                <td>{{$d->product->price?$d->product->price.'per unit':'-'}}</td>
            </tr>
            @endforeach
            <tr><td></td><td></td><td></td></tr>
            <tr><td></td><td></td><td></td></tr>
            <tr>
                <td>Amount Paid: </td>
                <td>{{$order->total_after_inspection}}</td>
            </tr>
            <tr>
                <td>Date: </td>
                <td>{{date('D d M Y H:A', strtotime($order->updated_at))}}</td>
            </tr>
        </table>
</body>
</html>
