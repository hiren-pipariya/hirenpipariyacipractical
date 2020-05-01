{{--  --}}
<div class="form-group row">
    <label for="photo" class="col-md-4 col-form-label text-md-right">
        Photo
    </label>
    
    <div class="col-md-3">
        <img src="{{Storage::url($form['photo'])}}" class="img-thumbnail" alt="">
    </div>
    <div class="col-md-3">
        <input type="file" class="form-control-file @error('photo') is-invalid @enderror" accept="image/*" name="photo" id="photo">
        <small id="emailHelp" class="form-text text-muted">Max size 2048 kb.</small>
        @if($errors->has('photo'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('photo') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class='form-group row'>
    {!! Form::label('first_name', 'Firstname:',['class' => 'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::text('first_name', null, ['class' => 'form-control','id' => 'first_name'])!!}
    </div>

    @if($errors->has('first_name'))
        <span class="help-block m-b-none">{{ $errors->first('first_name') }}</span>
    @endif
</div>
<div class='form-group row'>
    {!! Form::label('last_name', 'Lastname:',['class' => 'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::text('last_name', null, ['class' => 'form-control','id' => 'last_name'])!!}
    </div>

    @if($errors->has('last_name'))
        <span class="help-block m-b-none">{{ $errors->first('last_name') }}</span>
    @endif
</div>
<div class='form-group row'>
    {!! Form::label('mobile', 'Mobile number:',['class' => 'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::text('mobile', null, ['class' => 'form-control','id' => 'mobile'])!!}
    </div>

    @if($errors->has('mobile'))
        <span class="help-block m-b-none">{{ $errors->first('mobile') }}</span>
    @endif
</div>
<div class='form-group row'>
    {!! Form::label('email', 'Email:',['class' => 'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::email('email', null, ['class' => 'form-control','id' => 'email'])!!}
    </div>
    
    @if($errors->has('email'))
    <span class="help-block m-b-none">{{ $errors->first('email') }}</span>
    @endif
</div>
<div class='form-group row'>
    {!! Form::label('gender', 'Gender:',['class' => 'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-3">
        {!! Form::label('male', 'Male:') !!}
        {!! Form::radio('gender', 'male', null ,['class' => 'form-control']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::label('female', 'Female:') !!}
        {!! Form::radio('gender', 'female', null ,['class' => 'form-control']) !!}
    </div>
    @if($errors->has('gender'))
        <span class="help-block m-b-none">{{ $errors->first('gender') }}</span>
    @endif
</div>
<div class='form-group row'>
    {!! Form::label('skills', 'Skills:',['class' => 'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::select('skills[]',$skill_option, null,['class' => 'form-control','id' => 'skills-option','multiple'=>'multiple', 'required' => 'required']) !!}
    </div>
    @if($errors->has('skills'))
        <span class="help-block m-b-none">{{ $errors->first('gender') }}</span>
    @endif
</div>
<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-4">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>