@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(isset($userdetail) && $userdetail)
                        <div class="row">
                            <div class="col-md-4 justify-content-center">
                                <img src="{{$userdetail->image}}" class="img-thumbnail" alt="test">
                            </div>
                            <div class="col-md-7 justify-content-center">
                                <div class="row">
                                    <div class="col-md-4">
                                        First Name
                                    </div>
                                    <div class="col-md-6">
                                        {{$userdetail->first_name}}
                                    </div>
                                    <div class="col-md-4">
                                        Last Name
                                    </div>
                                    <div class="col-md-6">
                                        {{$userdetail->last_name}}
                                    </div>
                                    <div class="col-md-4">
                                        User Name
                                    </div>
                                    <div class="col-md-6">
                                        {{$userdetail->user_name}}
                                    </div>
                                    <div class="col-md-4">
                                        Email
                                    </div>
                                    <div class="col-md-6">
                                        {{auth()->user()->email}}
                                    </div>
                                    <div class="col-md-4">
                                        Mobile number
                                    </div>
                                    <div class="col-md-6">
                                        {{$userdetail->mobile}}
                                    </div>
                                    <div class="col-md-4">
                                        Gender
                                    </div>
                                    <div class="col-md-6">
                                        {{$userdetail->gender}}
                                    </div>
                                    <div class="col-md-4">
                                        Skills
                                    </div>
                                    <div class="col-md-6">
                                        @if ($skills)
                                        {{$skills}}
                                        @else
                                            <label for="">Please send skills from edit profile section</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <hr/>
                    <div class="row">
                        <div class="col-12">
                            <ul>
                                <li><a href="{{ url('edit_profile')}}">Edit Profile</a></li>
                                <li><a href="{{ url('friend')}}">Friend</a></li>
                                <li><a href="{{ url('sameskill')}}">Same Skill User</a></li>
                                <li><a href="{{ url('pending_request')}}">Pending Request</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
