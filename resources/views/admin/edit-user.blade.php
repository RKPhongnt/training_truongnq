@extends('layouts.app')

@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">{{$user->username}}
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-7" style="padding-bottom:120px">
                    @if(count($errors)>0)
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                {{$error}}
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{route('admin.users.update', $user->id)}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">


                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Please Enter Email" value ="{{$user->email}}"/>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input id="password" type="password" class="form-control" name="password"  />
                        </div>


                        <div class="form-group">
                            <label>User Level</label>
                            @if ($user->is_admin)
                                <label class="radio-inline">
                                    <input name="is_admin" value="1" checked="true" type="radio">Admin
                                </label>
                                <label class="radio-inline">
                                    <input name="is_admin" value="0" type="radio">User
                                </label>
                            @else
                                <label class="radio-inline">
                                    <input name="is_admin" value="1" type="radio">Admin
                                </label>
                                <label class="radio-inline">
                                    <input name="is_admin" value="0" checked="true" type="radio">User
                                </label>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>

                    </form>
                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection


@section('menu')

    @include('admin.menu')

@endsection