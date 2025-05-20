<?php $isActive = !empty(old('is_active')) ? old('is_active') : ($model->is_active ? $model->is_active : 1); ?>

<div class="row">
  <div class="col-md-8" style="border-right: 1px solid #d2d6de;">
    <div class="form-group @if($errors->has('title')) has-error @endif">
      <label for="">Title</label>
      <input type="text" class="form-control" name="title" placeholder="title" value="{{ !empty(old('title')) ? old('title') : $model->title }}">
      @if($errors->has('title'))
        <span class="help-block">{{ $errors->first('title') }}</span>
      @endif
    </div>

    <div class="form-group @if($errors->has('content')) has-error @endif">
      <label for="">content</label>
      <textarea class="form-control" rows="3" name="content" placeholder="content">{{ !empty(old('content')) ? old('content') : $model->content }}</textarea>
      @if($errors->has('content'))
        <span class="help-block">{{ $errors->first('content') }}</span>
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
      <img class="image-preview" src="{{ $model->image_url ? $model->image_url : asset('img/no-image.png') }}" width="100%" alt="image preview">
    </div>
  </div>
</div>