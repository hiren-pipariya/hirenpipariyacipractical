@extends('layouts.admin')
@section("title", "Edit Skill")
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Skill') }}</div>
                    <div class="card-body">
                        {!! Form::model($form, ['method' => 'PATCH', 'action' => ['SkillController@update',$form->id], 'id' => 'skillForm']) !!}
                            @include('skill.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
