@extends('adminlte::page')

@section('title', 'Edit Klinik')

@section('content_header')
    <h1>Edit Klinik</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <form action="{{ url($route . '/' . $model->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="box-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="nama">Nama Klinik</label>
                        <input type="text" class="form-control" name="nama" value="{{ $model->nama ?? $model->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3">{{ $model->alamat ?? $model->address }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="no_hp">No HP</label>
                        <input type="text" class="form-control" name="no_hp" value="{{ $model->no_hp ?? $model->phone }}">
                    </div>

                    <div class="form-group">
                        <label for="jadwal">Jadwal</label>
                        <textarea class="form-control" name="jadwal" rows="3">{{ $model->jadwal ?? $model->schedule }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="3" required>{{ $model->deskripsi ?? $model->description }}</textarea>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ url($route) }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop