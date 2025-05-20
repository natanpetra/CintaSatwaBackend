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
                    <th>Nama Pasien</th>
                    <th>Nama Peliharaan</th>
                    <th>Jenis Peliharaan</th>
                    <th>Tanggal & Waktu</th>
                    <th>Keluhan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $index => $item)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->pet_name }}</td>
                    <td>{{ $item->pet_type }}</td>
                    <td>{{ $item->reservation_date }} - {{ $item->reservation_time }}</td>
                    <td>
                        <strong>Keluhan:</strong> {{ $item->symptoms }} <br>
                        @if($item->doctor_notes)
                            <strong>Catatan Dokter:</strong> {{ $item->doctor_notes }}
                        @endif
                    </td>

                    <td>
                    <button class="btn btn-xs btn-primary" data-toggle="modal"
                            data-target="#noteModal{{$item->id}}">
                        Beri Notes
                    </button>
                    <button 
                        class="confirmation-delete btn btn-default text-red"
                        data-target="{{ url($route . '/' . $item->id) }}"
                        data-token={{ csrf_token() }}
                    >
                        <i class="fa fa-trash"></i>
                    </button>
                  </td>
                </tr>
                <div class="modal fade" id="noteModal{{$item->id}}">
                  <div class="modal-dialog">
                    <form method="POST"
                          action="{{ route('reservations.note',$item->id) }}">
                      @csrf @method('PATCH')
                      <div class="modal-content">
                        <div class="modal-header"><h4>Catatan Reservasi</h4></div>
                        <div class="modal-body">
                          <textarea name="note" class="form-control"
                                    rows="4">{{ old('note',$item->note) }}</textarea>
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-default" data-dismiss="modal">Batal</button>
                          <button class="btn btn-success">Simpan</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
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