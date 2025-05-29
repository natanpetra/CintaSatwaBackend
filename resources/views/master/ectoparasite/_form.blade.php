<?php $isActive = !empty(old('is_active')) ? old('is_active') : ($model->is_active ? $model->is_active : 1); ?>

<div class="row">
  <div class="col-md-8" style="border-right: 1px solid #d2d6de;">
    <div class="form-group @if($errors->has('title')) has-error @endif">
      <label for="">Title</label>
      <input type="text" class="form-control" name="name" placeholder="name" value="{{ !empty(old('name')) ? old('name') : $model->name }}">
      @if($errors->has('name'))
        <span class="help-block">{{ $errors->first('name') }}</span>
      @endif
    </div>

    <div class="form-group @if($errors->has('symptoms')) has-error @endif">
      <label for="">Keluhan</label>
      <textarea class="form-control" rows="3" name="symptoms" placeholder="symptoms">{{ !empty(old('symptoms')) ? old('symptoms') : $model->symptoms }}</textarea>
      @if($errors->has('symptoms'))
        <span class="help-block">{{ $errors->first('symptoms') }}</span>
      @endif
    </div>
    
    <div class="form-group @if($errors->has('treatment')) has-error @endif">
      <label for="">Terapi</label>
      <textarea class="form-control" rows="3" name="treatment" placeholder="treatment">{{ !empty(old('treatment')) ? old('treatment') : $model->treatment }}</textarea>
      @if($errors->has('treatment'))
        <span class="help-block">{{ $errors->first('treatment') }}</span>
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