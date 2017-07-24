@extends('layouts.app')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <h1 class="page-header">List user in division {{$division->name}}
            </h1>
            <div class="row">
                @if (Session::has('message'))
                    <div class="alert-success">{{Session::get('message')}}</div>
                @endif

                @if(count($errors)>0)
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            {{$error}}
                        @endforeach
                    </div>
                @endif
            <!-- /.col-lg-12 -->
                <table class="table table-striped table-bordered table-hover" >
                    <thead>
                    <tr align="center" >
                        <th class="center">Reset password</th>
                        <th class="center">Username</th>
                        <th class="center">Email</th>
                        <th class="center">Division</th>
                        <th class="center">Role</th>
                        <th class="center">Position</th>
                        <th class="center">Delete</th>
                        <th class="center">Edit</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($users as $user)
                        <td><input type="checkbox"  value="{{$user->id}}" class="choose-to-resetPassword"></td>
                        <td>{{$user->username}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->division->name}}</td>
                        <td>
                            @if($user->is_admin)
                                Admin
                            @else
                                User
                        @endif
                        @if(empty($user->position))
                            <td>Null</td>
                        @else
                            <td>{{$user->position->name}}</td>
                        @endif

                        <td class="center"><i class="fa fa-trash-o fa-fw " ></i> <a href="{{route('admin.users.destroy', $user->id)}}" onclick="return confirm('Are you sure?')" class="delete-user-btn"  >delete</a></td>

                        <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{{route('admin.users.edit',$user->id)}}">edit</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $users->render() !!}

                <a class="btn btn-primary click-to-reset">Reset password</a>
                <a href="{{route('admin.export.to.excel')}}" class="btn btn-primary">Export to Exel</a>
                <a href="{{route('admin.users.new')}}" class="btn btn-primary">Add user</a>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->

    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('.click-to-reset').click(function(){
                var list_id = [];
                $('.choose-to-resetPassword:checked').each(function(i){
                    list_id[i] = $(this).val();
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post("/project/public/admin/resetMail",
                    {
                        data: list_id,
                    },
                    function(respont){
                        console.log(respont);
                        alert('ok');
                        location.reload();
                    });
            });
        });
    </script>
@endsection

@section('menu')

    @include('admin.menu')

@endsection