@extends('adminlte::page')

@section('title', 'Riwayat Pembelian')

@section('content_header')
    <h1>Riwayat Pembelian</h1>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data Riwayat Pembelian</h3>
            </div>
            <div class="box-body">
                <table id="historyTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Order</th>
                            <th>Nama Pembeli</th>
                            <th>No Telepon</th>
                            <th>Barang yang Dibeli</th>
                            <th>Status</th>
                            <th>Total Pembelian</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td>{{ $order->user->profile->phone ?? 'Tidak ada' }}</td>
                            <td>
                                @if($order->orderItems && $order->orderItems->count() > 0)
                                    @foreach($order->orderItems as $item)
                                        <div class="item-detail">
                                            <strong>{{ $item->product->name ?? 'Product not found' }}</strong><br>
                                            <small>Qty: {{ $item->quantity }} x Rp {{ number_format($item->subtotal / $item->quantity, 0, ',', '.') }}</small>
                                        </div>
                                        @if(!$loop->last)<hr style="margin: 5px 0;">@endif
                                    @endforeach
                                @else
                                    <em>No items found</em>
                                @endif
                            </td>
                            <td>
                                <select class="form-control status-select" data-order-id="{{ $order->id }}">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                </select>
                            </td>
                            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <button class="btn btn-sm btn-danger delete-btn" 
                                        data-target="{{ url($route . '/' . $order->id) }}"
                                        data-token="{{ csrf_token() }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#historyTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "order": [[ 0, "desc" ]]
    });

    // Handle status change
    $('.status-select').on('change', function() {
        var orderId = $(this).data('order-id');
        var newStatus = $(this).val();
        
        $.ajax({
            url: '/history/purchases/' + orderId + '/update-status',
            type: 'PUT',
            data: {
                status: newStatus,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                toastr.success('Status berhasil diperbarui');
            },
            error: function(xhr) {
                toastr.error('Gagal memperbarui status');
            }
        });
    });

    // Handle delete
    $('.delete-btn').on('click', function() {
        var url = $(this).data('target');
        var token = $(this).data('token');
        var row = $(this).closest('tr');
        
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: token
                },
                success: function(response) {
                    row.remove();
                    toastr.success('Data berhasil dihapus');
                },
                error: function(xhr) {
                    toastr.error('Gagal menghapus data');
                }
            });
        }
    });
});
</script>
@stop

@section('css')
<style>
.item-detail {
    margin-bottom: 5px;
}
.item-detail:last-child {
    margin-bottom: 0;
}
.status-select {
    width: 120px;
}
</style>
@stop