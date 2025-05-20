<!-- resources/views/admin/berita/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Riwayat Pemeriksaan')

@section('content_header')
<h1>Riwayat Pemeriksaan</h1>
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
                    <th>ID Pasien</th>
                    <th>Nama Pasien</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($scans as $index => $item)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $item->user->id }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>
                      <img 
                        src="{{ asset('storage/' . $item->photo) }}" 
                        alt="Scan Photo #{{ $item->id }}" 
                        style="max-width:100px; height:auto;"
                      >
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