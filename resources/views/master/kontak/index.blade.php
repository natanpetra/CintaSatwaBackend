<!-- resources/views/admin/kontak/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Kontak Messages')

@section('content_header')
<h1>Pesan Kontak</h1>
@stop

@section('content')
<div class="box box-danger">
    <div class="box-body">
        <table id="raw-table" class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Nama</th>
                    <th width="15%">Email</th>
                    <th width="35%">Pesan</th>
                    <th width="15%">Tanggal</th>
                    <th width="5%">Status</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kontaks as $index => $item)
                <tr @if($item->status == 'belum_dibaca') class="bg-warning" @endif>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->pesan }}</td>
                    <td>{{ date('d/m/Y H:i', strtotime($item->tanggal)) }}</td>
                    <td>
                        @if($item->status == 'sudah_dibaca')
                            <small class="label bg-green">Dibaca</small>
                        @else
                            <small class="label bg-yellow">Baru</small>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-default" href="{{ url($route . '/' . $item->id . '/edit') }}">
                                <i class="fa fa-eye"></i>
                            </a>
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
    $('#raw-table').DataTable({
        "order": [[ 4, "desc" ]] // Sort by date descending
    });
});
</script>
@endpush