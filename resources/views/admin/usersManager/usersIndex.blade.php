@extends('layouts.adminPanel')

@section('title-section')
<ul class="breadcrumbs">
    <li><a href="{{ route('admin') }}"><i class="fas fa-home"></i></a>&nbsp;|&nbsp;</li>
    <li><a>Users Manager</a></li>
</ul>
<div class="right-head">
    <div><a id="AllUsers" class="mybtn active myfilter" data-value="All" href="#">All</a></div>
    <div><a id="onlyAdmins" class="mybtn myfilter" data-value="Admin" href="#">Admins</a></div>
    <div><a id="onlyUsers" class="mybtn myfilter" data-value="User" href="#">Users</a></div>
    <div class="input-group md-form form-sm form-1 pl-0">
        <div class="input-group-prepend">
            <span class="input-group-text cyan lighten-2" id="basic-text1"><i class="fas fa-search text-white"
                aria-hidden="true"></i></span>
        </div>
        <input id="searchItem" class="form-control my-0 py-1" type="text" placeholder="Search" aria-label="Search">
    </div>
    <div><a href="{{ route('users.create')}}" class="mybtn">Add User</a></div>
</div>
@endsection

@section('content-section')
    <div class="content-container">
        @if(session()->get('success'))
            <div class="alert alert-success">
            {{ session()->get('success') }}
            </div>
        @endif

        <table id="mytable" class="data-container users">
            <thead>
                <tr>
                    <td>N°</td>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Phone</td>
                    <td>Vrf</td>
                    <td>Type</td>
                    <td colspan="2" style="text-align: center">Actions</td>
                </tr>
            </thead>
            <tbody>

                @php
                    $i = 1;
                @endphp

                @foreach($users as $user)

                    <tr>
                        <td>{{ $i++ }}</td>
                        <td class="username">{{ $user->name }}</td>
                        <td class="useremail">{{ $user->email }}</td>
                        <td class="userphone">{{ $user->phone }}</td>
                        <td>
                            @if ($user->isVerified == true)
                            <i style="font-size: 16px; color: green" class="fas fa-check-circle"></i>
                            @else
                            <i style="font-size: 16px; color: red;" class="fas fa-check-circle"></i>  
                            @endif
                        </td>
                        <td class="type">
                            @if ($user->hasRole("admin"))
                            Admin
                            @else
                            User
                            @endif
                        </td>
                        <td style="text-align: right">
                            <a href="{{ route('users.edit',$user->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        </td>
                        <td>
                            <form action="{{ route('users.destroy', $user->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" onclick="return confirm('Are you sure?')" type="submit"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
