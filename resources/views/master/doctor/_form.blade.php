<!-- resources/views/admin/berita/_form.blade.php -->

<div class="row">
  <div class="col-md-8" style="border-right: 1px solid #d2d6de;">
    <div class="form-group @if($errors->has('name')) has-error @endif">
      <label for="">Nama Dokter</label>
      <input type="text" class="form-control" name="name" placeholder="Nama Dokter" value="{{ !empty(old('name')) ? old('name') : $model->name }}">
      @if($errors->has('name'))
        <span class="help-block">{{ $errors->first('name') }}</span>
      @endif
    </div>
    
    <div class="form-group @if($errors->has('specialization')) has-error @endif">
      <label for="">Speasialis</label>
      <textarea class="form-control" id="specialization" rows="3" name="specialization" placeholder="Specialis">{{ !empty(old('specialization')) ? old('specialization') : $model->specialization }}</textarea>
      @if($errors->has('specialization'))
        <span class="help-block">{{ $errors->first('specialization') }}</span>
      @endif
    </div>
    
    <div class="form-group @if($errors->has('phone')) has-error @endif">
      <label for="">No HP</label>
      <input type="number" class="form-control" name="phone" placeholder="Phone Dokter" value="{{ !empty(old('phone')) ? old('phone') : $model->phone }}">
      @if($errors->has('phone'))
        <span class="help-block">{{ $errors->first('phone') }}</span>
      @endif
    </div>
    
    <div class="form-group">
      <label>Image</label>
      <input type="file" class="has-image-preview form-control" name="image">
    </div>
    
  </div>

  <div class="col-md-4" style="height: 100%;">
    <label>Image Preview</label>
    <div style="margin-top: 1rem;">
      <img class="image-preview" src="{{ asset('storage/' . $model->image) }}" width="100%" alt="image preview">
    </div>
  </div>
</div>

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>
<script>

</script>
@endsection