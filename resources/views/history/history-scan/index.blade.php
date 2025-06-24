@extends('adminlte::page')

@section('title', 'Riwayat Pemeriksaan')

@section('content_header')
    <h1>Riwayat Pemeriksaan</h1>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data Riwayat Pemeriksaan</h3>
                <div class="box-tools pull-right">
                    <a href="{{ url($route . '/export-pdf') }}" class="btn btn-primary btn-sm" target="_blank">
                        <i class="fa fa-file-pdf-o"></i> Export PDF
                    </a>
                </div>
            </div>
            <div class="box-body">
                <table id="scanTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Akun</th>
                            <th>Nama Akun jika diubah</th>
                            <th>No telepon</th>
                            <th>Tanggal & Waktu</th>
                            <th>Keluhan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scans as $index => $scan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $scan->user->name ?? 'N/A' }}</td>
                            <td>{{ $scan->user->name ?? 'N/A' }}</td>
                            <td>{{ $scan->user->profile->phone ?? 'Tidak ada' }}</td>
                            <td>
                                {{ $scan->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                <strong>Keluhan:</strong> {{ $scan->symptoms ?? 'anjing saya gatal pitbul' }}<br>
                                @if($scan->doctor_notes)
                                    <strong>Catatan Dokter:</strong> {{ $scan->doctor_notes }}
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-primary beri-notes" 
                                            data-id="{{ $scan->id }}"
                                            data-notes="{{ $scan->doctor_notes }}">
                                        Beri Notes
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-btn" 
                                            data-target="{{ url($route . '/' . $scan->id) }}"
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

<!-- Modal untuk Beri Notes -->
<div class="modal fade" id="notesModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Beri Catatan Dokter</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="notesForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="doctor_notes">Catatan Dokter:</label>
                        <textarea class="form-control" id="doctor_notes" name="note" rows="4" 
                                  placeholder="Masukkan catatan dokter..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#scanTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "order": [[ 0, "desc" ]]
    });

    // Handle Beri Notes
    $('.beri-notes').on('click', function() {
        var scanId = $(this).data('id');
        var currentNotes = $(this).data('notes');
        
        $('#doctor_notes').val(currentNotes);
        $('#notesForm').attr('action', '/history/scans/' + scanId + '/note');
        $('#notesModal').modal('show');
    });

    // Handle Notes Form Submit
    $('#notesForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        var url = $(this).attr('action');
        
        $.ajax({
            url: url,
            type: 'PATCH',
            data: formData,
            success: function(response) {
                $('#notesModal').modal('hide');
                toastr.success('Catatan berhasil disimpan');
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(xhr) {
                toastr.error('Gagal menyimpan catatan');
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