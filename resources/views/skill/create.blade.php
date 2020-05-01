@extends('layouts.admin')
@section("title", "Skill Create")
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create New Skill') }}</div>
                <div class="card-body">
                    {!! Form::open(['action' => 'SkillController@store', 'id' => 'projectTagForm', 'enctype' => 'multipart/form-data']) !!}
                        @include('skill.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection