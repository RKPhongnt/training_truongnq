@extends('layouts.app')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                @if (Session::has('message'))
                    <div class="alert-success">{{Session::get('message')}}</div>
                @endif
                <!-- /.col-lg-12 -->
                <table class="table table-striped table-bordered table-hover" >
                    <thead>
                    <tr align="center" >
                        <th class="center">Username</th>
                        <th class="center">Emails</th>
                        <th class="center">Division</th>
                        <th class="center">Is admin</th>
                        <th class="center">Delete</th>
                        <th class="center">Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr class="odd gradeX" align="center" id = "user_{{$user->id}}">
                            <td>{{$user->username}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->division->name}}</td>
                            <td>
                                @if($user->is_admin)
                                    Admin
                                @else
                                    User
                                @endif
                            <td class="center"><i class="fa fa-trash-o fa-fw " ></i> <a href="{{route('admin.users.destroy', $user->id)}}" onclick="return confirm('Are you sure?')" class="delete-user-btn"  >delete</a></td>

                            <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{{route('admin.users.edit',$user->id)}}">edit</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <button class="btn btn-primary click-to-reset">Reset password</button>
                <a href="" class="btn btn-primary">Export to Exel</a>
                <a href="{{route('admin.users.new')}}" class="btn btn-primary">Add user</a>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->

    </div>
@endsection


@section('menu')

    @include('admin.menu')

@endsection