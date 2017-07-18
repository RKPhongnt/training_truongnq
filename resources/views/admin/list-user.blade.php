@extends('layouts.app')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">

                <!-- /.col-lg-12 -->
                <table class="table table-striped table-bordered table-hover" >
                    <thead>
                    <tr align="center" >
                        <th class="center">username</th>
                        <th class="center">email</th>
                        <th class="center">is active</th>
                        <th class="center">delete</th>
                        <th class="center">edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr class="odd gradeX" align="center" id = "user_{{$user->id}}">
                            <td>{{$user->username}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if($user->is_active)
                                    <i class="fa fa-check" aria-hidden="true"></i></td>
                                @endif
                            <td class="center"><i class="fa fa-trash-o fa-fw " ></i> <a href="#" class="delete-user-btn" data={{$user->id}}>delete</a></td>

                            <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{{url('admin/users/'.$user->id.'/edit')}}">edit</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <button class="btn btn-primary click-to-reset">Reset password</button>
                <a href="#" class="btn btn-primary">Export to Exel</a>
                <a href="#" class="btn btn-primary">Add user</a>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->

    </div>
@endsection


@section('menu')

    @include('admin.menu')

@endsection