@extends('layouts.adminPanel')

@section('title-section')
<ul class="breadcrumbs">
    <li><a href="{{ route('admin') }}"><i class="fas fa-home"></i></a>&nbsp;|&nbsp;</li>
    <li><a>Media - Upload Files</a></li>
</ul>
@endsection

@section('content-section')
    <div class="content-container">

        <div class="add-new">
           
           {!! Form::open([
                'route' => 'images.store',
                'files' => true
            ]) !!}
        
            @csrf
        
            <div class="form-group-files">
                {!! Form::label('name', 'Select Files', ['class' => 'control-label']) !!}
                <input type="file" name="attachement[]" class="select-file" multiple>
                {!! Form::submit('Upload', ['class' => 'mybtn']) !!}
            </div>
        
                @if(session()->get('error'))
                    <div class="alert alert-danger">
                    {{ session()->get('error') }}
                    </div>
                @endif
                @if(session()->get('success'))
                    <div class="alert alert-success">
                    {{ session()->get('success') }}
                    </div>
                @endif
        
            
        
            {!! Form::close() !!}
        
        </div>
        
        <div class="exist-media">
        
            @foreach($images as $image)
                <div class="image-container">
                    <img class="image" src="{{asset('/images/admin/' . $image->filename)}}" alt="media" title="{{$image->filename}}">
                <form action="{{route('images.destroy', $image->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="del-image" onclick="return confirm('Are you sure ?')" type="submit">Delete</button>
                </form>
                </div>
            @endforeach
        
            <div class="clear"></div>
        
        </div>

    </div>
@endsection
