@extends('layouts.adminPanel')

@section('title-section')
<ul class="breadcrumbs">
    <li><a href="{{ route('admin') }}"><i class="fas fa-home"></i></a>&nbsp;|&nbsp;</li>
    <li><a href="{{route('locations.index')}}">Locations</a>&nbsp;|&nbsp;</li>
    <li><a>Add Location</a></li>
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
                    'route' => 'locations.store',
                ]) !!}

                @csrf

                <div class="form-group">
                    {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
                    {!! Form::text('name', null , ['class' => 'input-text']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('state', 'State:', ['class' => 'control-label']) !!}
                    {!! Form::select('state', $states, ['class' => 'input-text', 'placeholder' => 'None']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('order', 'Order:', ['class' => 'control-label']) !!}
                    {!! Form::number('order', 0 , ['class' => 'input-text']) !!}
                </div>

                {!! Form::submit('Add', ['class' => 'input-submit mybtn']) !!}

                {!! Form::close() !!}

        </div>
    </div>

@endsection

