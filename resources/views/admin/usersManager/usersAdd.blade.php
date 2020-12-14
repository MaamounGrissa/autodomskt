@extends('layouts.adminPanel')

@section('title-section')
<ul class="breadcrumbs">
    <li><a href="{{ route('admin') }}"><i class="fas fa-home"></i></a>&nbsp;|&nbsp;</li>
    <li><a href="{{route('users.index')}}">Users Manager</a>&nbsp;|&nbsp;</li>
    <li><a>Add User</a></li>
</ul>
@endsection

@section('content-section')

    <div class="content-container">

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br />
        @endif

        <div class="form-container">

                {!! Form::open([
                    'route' => 'users.store'
                ]) !!}

                @csrf

                <div class="form-group">
                    {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
                    {!! Form::text('name', null , ['class' => 'input-text']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'Email:', ['class' => 'control-label']) !!}
                    {!! Form::email('email', null , ['class' => 'input-text']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('phone', 'phone:', ['class' => 'control-label']) !!}
                    {!! Form::tel('phone', null , ['class' => 'input-text']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('isVerified', 'Tel Verification:', ['class' => 'control-label']) !!}
                    {!! Form::select('isVerified', array('true' => 'Verified', 'false' => 'Unverified')) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'Password:', ['class' => 'control-label']) !!}
                    {!! Form::password('password', null , ['class' => 'input-text']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('userType', 'User Type:', ['class' => 'control-label']) !!}
                    {!! Form::select('userType', array('user' => 'User', 'admin' => 'Admin')) !!}
                </div>

                {!! Form::submit('Add', ['class' => 'input-submit mybtn']) !!}

                {!! Form::close() !!}

        </div>
    </div>

@endsection

