@extends('layouts.web')
@section("title", "Edit Skill")
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Skill') }}</div>
                    <div class="card-body">
                        {!! Form::model($form, ['method' => 'PATCH', 'action' => ['UserController@update_profile',$form['id']], 'id' => 'profileForm', 'enctype' => "multipart/form-data" ]) !!}
                            @include('profile.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
