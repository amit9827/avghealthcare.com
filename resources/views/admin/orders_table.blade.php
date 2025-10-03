<table class="table table-striped table-full-width">
    <thead>
        <tr>
            <th><input type="checkbox" name="select_all"></th>
            <th>Order</th>
            <th>Date</th>
            <th>Status</th>
            <th>Payment Mode</th>
            <th>Dispatch</th>
            <th>Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @forelse ($orders as $order)
        <tr>
            <td><input type="checkbox" name="order_ids[]"></td>
            <td>
                <a href="{{ route('admin.order_get', $order->id) }}">
                    #{{ $order->id }} {{ $order->customer->name ?? '' }}
                </a>
            </td>
            <td>{{ $order->created_at }}</td>
            <td>{{ ucfirst($order->order_status) }}</td>
            <td>{{ $order->payment_mode }}</td>
            <td>{{ $order->dispatch_status }}</td>
            <td>{{ $order->total_amount }}</td>
            <td>
                <a href="{{ route('admin.order_delete', $order->id) }}" onclick="return confirm('Are you sure ?')">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="text-center">No orders found.</td></tr>
    @endforelse
    </tbody>
</table>
