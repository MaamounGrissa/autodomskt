@extends('layouts.adminPanel')

@section('title-section')
<ul class="breadcrumbs">
    <li><a href="{{ route('admin') }}"><i class="fas fa-home"></i></a>&nbsp;|&nbsp;</li>
    <li><a>Locations</a></li>
</ul>
<div class="right-head">
    <div class="input-group md-form form-sm form-1 pl-0">
        <div class="input-group-prepend">
            <span class="input-group-text cyan lighten-2" id="basic-text1"><i class="fas fa-search text-white"
                aria-hidden="true"></i></span>
        </div>
        <input id="searchItem" class="form-control my-0 py-1" type="text" placeholder="Search" aria-label="Search">
    </div>
    <div><a href="{{ route('locations.create')}}" class="mybtn">Add Location</a></div>
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
                    <td>Name</td>
                    <td colspan="2" style="text-align: center">Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach($states as $state)

                    <tr style="background-color: #eef9ff !important">
                        <td style="text-align: center; width: 40px">{{ $state->order }}</td>   
                        <td class="username">{{ $state->name }}</td>
                        <td style="text-align: right">
                            <a href="{{ route('locations.edit',$state->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        </td>
                        <td>
                            <form action="{{ route('locations.destroy', $state->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" onclick="return confirm('Are you sure?')" type="submit"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>

                    @foreach ($locations as $location)
                        @if ($location->state == $state->id)
                            <tr style="background-color: #fff !important">
                                <td style="width: 40px; text-align: center;">--&nbsp;{{ $location->order }}</td>
                                <td class="username">--&nbsp;{{ $location->name }}</td>
                                <td style="text-align: right">
                                    <a href="{{ route('locations.edit',$location->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                </td>
                                <td>
                                    <form action="{{ route('locations.destroy', $location->id)}}" method="post">
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
