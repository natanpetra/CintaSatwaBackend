<!-- resources/views/admin/kontak/_form.blade.php -->

<div class="form-group @if($errors->has('nama')) has-error @endif">
  <label for="">Nama Pengirim</label>
  <input type="text" class="form-control" name="nama" placeholder="Nama" value="{{ !empty(old('nama')) ? old('nama') : $model->nama }}">
  @if($errors->has('nama'))
    <span class="help-block">{{ $errors->first('nama') }}</span>
  @endif
</div>

<div class="form-group @if($errors->has('email')) has-error @endif">
  <label for="">Email</label>
  <input type="email" class="form-control" name="email" placeholder="Email" value="{{ !empty(old('email')) ? old('email') : $model->email }}">
  @if($errors->has('email'))
    <span class="help-block">{{ $errors->first('email') }}</span>
  @endif
</div>

<div class="form-group @if($errors->has('pesan')) has-error @endif">
  <label for="">Pesan</label>
  <textarea class="form-control" rows="4" name="pesan" placeholder="Pesan">{{ !empty(old('pesan')) ? old('pesan') : $model->pesan }}</textarea>
  @if($errors->has('pesan'))
    <span class="help-block">{{ $errors->first('pesan') }}</span>
  @endif
</div>

<div class="form-group">
  <label>Status</label>
  <select class="form-control" name="status" style="width: 100%;" tabindex="-1">
      <option value="belum_dibaca" @if($model->status == 'belum_dibaca') selected @endif>Belum Dibaca</option>
      <option value="sudah_dibaca" @if($model->status == 'sudah_dibaca') selected @endif>Sudah Dibaca</option>
  </select>
</div>