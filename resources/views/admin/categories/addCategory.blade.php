@extends('layouts.adminPanel')

@section('title-section')
<ul class="breadcrumbs">
    <li><a href="{{ route('admin') }}"><i class="fas fa-home"></i></a>&nbsp;|&nbsp;</li>
    <li><a href="{{route('categories.index')}}">Categories</a>&nbsp;|&nbsp;</li>
    <li><a>Add Category</a></li>
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
                    'route' => 'categories.store',
                    'class' => 'checkImage'
                ]) !!}

                @csrf

                <div class="form-group">
                    {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
                    {!! Form::text('name', null , ['class' => 'input-text']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('parent', 'Parent:', ['class' => 'control-label']) !!}
                    {!! Form::select('parent', $mainCategories, ['class' => 'input-text', 'placeholder' => 'None']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('order', 'Order:', ['class' => 'control-label']) !!}
                    {!! Form::number('order', 0 , ['class' => 'input-text']) !!}
                </div>

                <div class="form-group-image">
                    {!! Form::label('logo', 'Select Icon:', ['class' => 'control-label radio-label']) !!}
                    <div id="select" class="selected" style="background-image: url('{{asset('images/icons/add.png')}}')">
                    </div>
                    <div id="container" class="all-images-container">

                        @foreach($images as $i=>$image)
                            <label class="image-container" for="image{{$i}}">
                                <input type="radio" name="image" id="image{{$i}}" value="{{$image->id}}">
                                <img src="{{asset('images/admin/' . $image->filename)}}" alt="image">
                            </label>
                        @endforeach
                        
                        <div class="clear"></div>

                    </div>
                    <div class="clear"></div>
                </div>

                {!! Form::submit('Add', ['class' => 'input-submit mybtn']) !!}

                {!! Form::close() !!}

        </div>
    </div>

@endsection

