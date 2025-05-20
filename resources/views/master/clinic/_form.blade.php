<!-- resources/views/admin/berita/_form.blade.php -->

<div class="form-group @if($errors->has('name')) has-error @endif">
  <label for="">Nama Klinik</label>
  <input type="text" class="form-control" name="name" placeholder="Nama Klinik" value="{{ !empty(old('name')) ? old('name') : $model->name }}">
  @if($errors->has('name'))
    <span class="help-block">{{ $errors->first('name') }}</span>
  @endif
</div>

<div class="form-group @if($errors->has('address')) has-error @endif">
  <label for="">Alamat</label>
  <textarea class="form-control" id="address" rows="3" name="address" placeholder="address">{{ !empty(old('address')) ? old('address') : $model->address }}</textarea>
  @if($errors->has('address'))
    <span class="help-block">{{ $errors->first('address') }}</span>
  @endif
</div>

<div class="form-group @if($errors->has('phone')) has-error @endif">
  <label for="">No HP</label>
  <input type="text" class="form-control" name="phone" value="{{ !empty(old('phone')) ? old('phone') : ($model->phone ? date('Y-m-d', strtotime($model->phone)) : date('Y-m-d')) }}">
  @if($errors->has('phone'))
    <span class="help-block">{{ $errors->first('phone') }}</span>
  @endif
</div>

<div class="form-group @if($errors->has('schedule')) has-error @endif">
  <label for="">Jadwal</label>
  <textarea class="form-control" id="schedule" rows="3" name="schedule" placeholder="Schedule">{{ !empty(old('schedule')) ? old('schedule') : $model->schedule }}</textarea>
  @if($errors->has('schedule'))
    <span class="help-block">{{ $errors->first('schedule') }}</span>
  @endif
</div>

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>
<script>

</script>
@endsection