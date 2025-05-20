<?php $category = !empty(old('category')) ? old('category') : ($model->category ? $model->category : 'obat'); ?>

<div class="row">
  <div class="col-md-8" style="border-right: 1px solid #d2d6de;">
    
    <div class="form-group @if($errors->has('name')) has-error @endif">
      <label for="">Name</label>
      <input type="text" class="form-control" name="name" placeholder="banner name" value="{{ !empty(old('name')) ? old('name') : $model->name }}">
      @if($errors->has('name'))
        <span class="help-block">{{ $errors->first('name') }}</span>
      @endif
    </div>

    <div class="form-group @if($errors->has('description')) has-error @endif">
      <label for="">Description</label>
      <textarea class="form-control" rows="3" name="description" placeholder="banner description">{{ !empty(old('description')) ? old('description') : $model->description }}</textarea>
      @if($errors->has('description'))
        <span class="help-block">{{ $errors->first('description') }}</span>
      @endif
    </div>

    <div class="form-group @if($errors->has('price')) has-error @endif">
      <label for="">Price</label>
      <input type="text" class="form-control" name="name" placeholder="Price" value="{{ !empty(old('price')) ? old('price') : $model->name }}">
      @if($errors->has('price'))
        <span class="help-block">{{ $errors->first('price') }}</span>
      @endif
    </div>

    <div class="form-group @if($errors->has('stock')) has-error @endif">
      <label for="">Stock</label>
      <input type="number" class="form-control" name="stock" placeholder="Stock" value="{{ !empty(old('stock')) ? old('stock') : $model->stock }}">
      @if($errors->has('stock'))
        <span class="help-block">{{ $errors->first('stock') }}</span>
      @endif
    </div>
      
    <div class="form-group">
      <label>Image</label>
      <input type="file" class="has-image-preview form-control" id="" name="image" value="">
    </div>

    <div class="form-group">
      <label>Category</label>
      <select class="form-control " name="category" id="" style="width: 100%;" tabindex="-1">
          <option value="obat" @if($category == 'obat') selected @endif>Obat</option>
          <option value="perawatan" @if($category == 'perawatan') selected @endif>Perawatan</option>
      </select>
    </div>
  </div>

  <div class="col-md-4" style="height: 100%;">
    <label>Image Preview</label>
    <div style="margin-top: 1rem;">
      <img class="image-preview" src="{{ $model->image_url ? $model->image_url : asset('img/no-image.png') }}" width="100%" alt="image preview">
    </div>
  </div>
</div>