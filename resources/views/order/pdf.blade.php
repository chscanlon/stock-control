

    <h1>Order Detail</h1>

    <table style="border: 1px solid black;">
        <tr>
            <th>Supplier</th>
            <td> {{$order->supplier}} </td>
        </tr>
        <tr>
            <th>Order Date</th>
            <td> {{$order->order_date}} </td>
        </tr>
        <tr>
            <th>Status</th>
            <td> {{$order->status}} </td>
        </tr>
        <tr>
            <th>Item Count</th>
            <td> {{$order->item_count}} </td>
        </tr>

    </table>

    <table style="border-collapse: collapse; border: 1px solid black;">
        <tr style="border: 1px solid black;">
            {{-- <th>Supplier</th> --}}
            <th style="border: 1px solid black;">Display Name</th>
            <th style="border: 1px solid black;">Order Amount</th>
            {{-- <th>Max Stock</th>
            <th>Available Stock</th> --}}
        </tr>

        @foreach ($order->orderItems as $orderItem)

        <tr style="border: 1px solid black;">
            {{-- <td> {{$orderItem->supplier}} </td> --}}
            <td> {{$orderItem->display_name}} </td>
            <td> {{$orderItem->order_amount}} </td>
            {{-- <td> {{$orderItem->max_stock}} </td>
            <td> {{$orderItem->available_stock}} </td> --}}
        </tr>

        @endforeach

    </table>
