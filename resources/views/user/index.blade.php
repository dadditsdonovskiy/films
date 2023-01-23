@extends('layouts.adminlte')
@section('title', 'Dashboard')

@section('header')
    <h1>Users</h1>
@stop
@section('content')
    <table class="table table-bordered" aria-describedby="Users">
        <thead>
        <tr>
            <th scope="row">Id</th>
            <th scope="row">Email</th>
            <th scope="row">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->email}}</td>
                <td>
                    @include('components.actions',['url'=>url("/user/{$user->id}"),'actions'=>['delete']])
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@stop


