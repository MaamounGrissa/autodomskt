@extends('layouts.adminPanel')

@section('title-section')
<ul class="breadcrumbs">
    <li><a href="{{ route('admin') }}"><i class="fas fa-home"></i></a>&nbsp;|&nbsp;</li>
    <li><a href="{{route('categories.index')}}">Categories</a>&nbsp;|&nbsp;</li>
    <li><a>Edit Category</a></li>
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

                {!! Form::model($category, [
                    'method' => 'PATCH',
                    'route' => ['categories.update', $category->id],
                    'class' => 'checkImage'
                ]) !!}

                @csrf

                <div class="form-group">
                    {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
                    {!! Form::text('name', null , ['class' => 'input-text']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('parent', 'Parent:', ['class' => 'control-label']) !!}
                    {!! Form::select('parent', $mainCategories, $category->parent, ['class' => 'input-text']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('order', 'Order:', ['class' => 'control-label']) !!}
                    {!! Form::number('order', $category->order , ['class' => 'input-text']) !!}
                </div>

                <div class="form-group-image">
                    {!! Form::label('logo', 'Select Icon:', ['class' => 'control-label radio-label']) !!}
                    @if (isset($category->image))
                    <div id="select" data-img="{{asset('images/icons/add.png')}}" class="selected" style="background-image: url('{{asset('images/admin/' . $category->image->filename)}}')"></div>
                    @else
                    <div id="select" data-img="{{asset('images/icons/add.png')}}" class="selected" style="background-image: url('{{asset('images/icons/add.png')}}')"></div>
                    <div class="alert alert-warning" style="width: 100%; display: none" role="alert">
                        Select an icon please !
                    </div>
                    @endif
                    <div id="container" class="all-images-container">

                        @foreach($images as $i=>$image)
                        <label class="image-container" for="image{{$i}}">
                            @if (isset($category->image) && ($image->id == $category->image->id))
                                <input type="radio" name="image" id="image{{$i}}" value="{{$image->id}}" checked>
                            @else
                                <input type="radio" name="image" id="image{{$i}}" value="{{$image->id}}"> 
                            @endif
                            <img src="{{asset('images/admin/' . $image->filename)}}" alt="image">
                        </label>
                        @endforeach
                        
                        <div class="clear"></div>

                    </div>
                    <div class="clear"></div>
                </div>

                {!! Form::submit('Edit', ['class' => 'input-submit mybtn']) !!}

                {!! Form::close() !!}

        </div>
    </div>

@endsection

