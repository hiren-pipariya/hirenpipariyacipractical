<div class='form-group row'>
    {!! Form::label('skill', 'Skill:',['class' => 'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::text('skill', null, ['class' => 'form-control','id' => 'skill'])!!}
    </div>

    @if($errors->has('skill'))
        <span class="help-block m-b-none">{{ $errors->first('skill') }}</span>
    @endif
</div>
<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-4">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>