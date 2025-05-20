<!-- resources/views/admin/berita/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Riwayat Pembelian')

@section('content_header')
<h1>Riwayat Pembelian</h1>
@stop

@section('content')
<div class="box box-danger">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <table id="raw-table" class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Order</th>
                    <th>Nama Pembeli</th>
                    <th>Status</th>
                    <th>Total Pembelian</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($history as $index => $item)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->total_price }}</td>
                    <td>
                        <form action="{{ route('purchases.update-status', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()">
                                <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $item->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="completed" {{ $item->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="canceled" {{ $item->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@push('js')
<script type="text/javascript">
$(document).ready(function() {
    $('#raw-table').DataTable();
});
</script>
@endpush