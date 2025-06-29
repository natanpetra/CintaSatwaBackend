<!-- resources/views/admin/berita/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Dokter')

@section('content_header')
<h1>Dokter</h1>
@stop

@section('content')
<div class="box box-danger">
    <div class="box-header with-border">
        <a href="{{ url($route . '/create') }}" ><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add Dokter</button></a>
    </div>
    <div class="box-body">
        <table id="raw-table" class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Dokter</th>
                    <th>Spesialis</th>
                    <th>No HP</th>
                    <th>Foto</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($doctors as $index => $item)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->specialization }}</td>
                    <td>{{ $item->phone }}</td>
                    <td><img src="{{ asset('storage/' . $item->image) }}" width="100" height="100" /></td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-default" href="{{ url($route . '/' . $item->id . '/edit') }}"><i class="fa fa-pencil"></i></a>
                            <button 
                                class="confirmation-delete btn btn-default text-red"
                                data-target="{{ url($route . '/' . $item->id) }}"
                                data-token={{ csrf_token() }}
                            >
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
@stop

@push('js')
<script type="text/javascript">
$(document).ready(function() {
    $('#raw-table').DataTable();
});
</script>
@endpush