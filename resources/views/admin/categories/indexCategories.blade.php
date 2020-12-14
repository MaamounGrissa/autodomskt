@extends('layouts.adminPanel')

@section('title-section')
<ul class="breadcrumbs">
    <li><a href="{{ route('admin') }}"><i class="fas fa-home"></i></a>&nbsp;|&nbsp;</li>
    <li><a>Categories</a></li>
</ul>
<div class="right-head">
    <div class="input-group md-form form-sm form-1 pl-0">
        <div class="input-group-prepend">
            <span class="input-group-text cyan lighten-2" id="basic-text1"><i class="fas fa-search text-white"
                aria-hidden="true"></i></span>
        </div>
        <input id="searchItem" class="form-control my-0 py-1" type="text" placeholder="Search" aria-label="Search">
    </div>
    <div><a href="{{ route('categories.create')}}" class="mybtn">Add Category</a></div>
</div>
@endsection

@section('content-section')
    <div class="content-container">
        @if(session()->get('success'))
            <div class="alert alert-success">
            {{ session()->get('success') }}
            </div>
        @endif

        <table id="mytable" class="data-container categories">
            <thead>
                <tr>
                    <td style="width: 40px">Order</td>
                    <td style="width: 50px; text-align: center;">Icon</td>
                    <td>Name</td>
                    <td colspan="2" style="text-align: center">Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach($mainCategories as $mainCategory)

                    <tr style="background-color: #eef9ff !important;">
                        <td style="text-align: center; width: 40px">{{ $mainCategory->order }}</td>
                        @if (isset($mainCategory->image))
                            <td style="width: 50px; text-align: center;"><img style="width: 40px; height: 35px;" src="{{asset("images/admin/" . $mainCategory->image->filename)}}" alt="Icon"></td>
                        @else
                            <td style="width: 50px; text-align: center;"></td>
                        @endif    
                        <td class="username">{{ $mainCategory->name }}</td>
                     
                        <td style="text-align: right">
                            <a href="{{ route('categories.edit',$mainCategory->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        </td>
                        <td>
                            <form action="{{ route('categories.destroy', $mainCategory->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" onclick="return confirm('Are you sure?')" type="submit"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>

                    @foreach ($categories as $category)
                        @if ($category->parent == $mainCategory->id)
                            <tr style="background-color: #fff !important">
                                <td style="width: 40px; text-align: center;">--&nbsp;{{ $category->order }}</td>
                                <td style="width: 50px; text-align: center;"></td>
                                <td class="username">--&nbsp;{{ $category->name }}</td>
                                <td style="text-align: right">
                                    <a href="{{ route('categories.edit',$category->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                </td>
                                <td>
                                    <form action="{{ route('categories.destroy', $category->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" onclick="return confirm('Are you sure?')" type="submit"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
