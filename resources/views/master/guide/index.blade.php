@extends('adminlte::page')

@section('title', 'Dog Care Guide')

@section('content_header')
    <h1>Dog Care Guide</h1>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data Dog Care Guide</h3>
                <div class="box-tools pull-right">
                    <a href="{{ url($route . '/create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> New Guide
                    </a>
                </div>
            </div>
            <div class="box-body">
                <table id="guideTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Konten</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guides as $index => $guide)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $guide->title }}</td>
                            <td>{{ Str::limit($guide->content, 50) }}</td>
                            <td>
                                @if($guide->image)
                                    <img src="{{ $guide->image_url }}" alt="{{ $guide->title }}" class="img-thumbnail" style="max-width: 80px; max-height: 80px;">
                                @else
                                    <img src="{{ asset('img/no-image.png') }}" alt="No Image" class="img-thumbnail" style="max-width: 80px; max-height: 80px;">
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ url($route . '/' . $guide->id . '/edit') }}" class="btn btn-default btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button class="confirmation-delete btn btn-default btn-sm text-red" 
                                            data-target="{{ url($route . '/' . $guide->id) }}"
                                            data-token="{{ csrf_token() }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
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
    $('#guideTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "order": [[ 0, "asc" ]],
        "columnDefs": [
            { "orderable": false, "targets": [2, 3, 4] }, // Disable ordering for content, image, and action columns
            { "width": "5%", "targets": 0 },
            { "width": "25%", "targets": 1 },
            { "width": "40%", "targets": 2 },
            { "width": "15%", "targets": 3 },
            { "width": "15%", "targets": 4 }
        ]
    });

    // Show more content
    // Removed - not needed anymore

    // Show less content  
    // Removed - not needed anymore

    // Handle delete confirmation
    $('.confirmation-delete').on('click', function() {
        var url = $(this).data('target');
        var token = $(this).data('token');
        var row = $(this).closest('tr');
        
        if (confirm('Apakah Anda yakin ingin menghapus guide ini?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: token
                },
                success: function(response) {
                    row.remove();
                    toastr.success('Guide berhasil dihapus');
                },
                error: function(xhr) {
                    toastr.error('Gagal menghapus guide');
                }
            });
        }
    });
});
</script>
@stop

@section('css')
<style>
.img-thumbnail {
    border-radius: 4px;
    cursor: pointer;
    transition: transform 0.2s;
    max-width: 80px;
    max-height: 80px;
}

.img-thumbnail:hover {
    transform: scale(1.05);
}

.table > tbody > tr > td {
    vertical-align: middle;
}
</style>
@stop