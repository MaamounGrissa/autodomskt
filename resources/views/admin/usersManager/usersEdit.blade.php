@extends('layouts.adminPanel')

@section('title-section')
<ul class="breadcrumbs">
    <li><a href="{{ route('admin') }}"><i class="fas fa-home"></i></a>&nbsp;|&nbsp;</li>
    <li><a href="{{route('users.index')}}">Users Manager</a>&nbsp;|&nbsp;</li>
    <li><a>Edit User</a></li>
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

                {!! Form::model($user, [
                    'method' => 'PATCH',
                    'route' => ['users.update', $user->id],
                ]) !!}

                @csrf

                <div class="form-group">
                    {!! Form::label('name', 'Name :', ['class' => 'control-label']) !!}
                    {!! Form::text('name', null , ['class' => 'input-text']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('phone', 'Phone:', ['class' => 'control-label']) !!}
                    {!! Form::tel('phone', null , ['class' => 'input-text']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('isVerified', 'Tel Verification:', ['class' => 'control-label']) !!}
                    {!! Form::select('isVerified', array('true' => 'Verified', 'false' => 'Unverified'), $isverified) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'Email:', ['class' => 'control-label']) !!}
                    {!! Form::email('email', null , ['class' => 'input-text']) !!}
                </div>

                <a href="#" class="btn btn-warning" data="reset-password" style="margin: 10px 0 25px; font-weight: bold;">Reset Password</a>
                
                <div class="form-group">
                    {!! Form::label('userType', 'User Type:', ['class' => 'control-label']) !!}
                    {!! Form::select('userType', array('user' => 'User', 'admin' => 'Admin'), $usertype) !!}
                </div>

                {!! Form::submit('Edit', ['class' => 'input-submit mybtn']) !!}

                {!! Form::close() !!}

        </div>

        <div id="reset" class="reset-password-modal" data-store="{{ $user->id }}">
            <div class="modal-content">
                <a href="#" id="close-modal"><i class="far fa-times-circle"></i></a>

            <form method="POST" name="password-reset" action="{{ route("resetPass")}}">
                    @csrf
                    <div class="form-group">
                        <label for="password" class="control-label">New Password</label>
                        <input id="password" type="password" class="input-text" name="password" required autocomplete="new-password">
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="control-label">Confirm password</label>
                        <input id="password-confirm" type="password" class="input-text" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div id="error-confirmation" class="alert alert-danger"></div>
                    <div id="success" class="alert alert-success"></div>
                    <input type="submit" class="mybtn" value="Save">

                </form>
            </div>
        </div>

    </div>

@endsection

