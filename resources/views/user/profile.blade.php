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

                    <form method="POST" action="{{route('update.profile')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label>Email</label>
                            {{$user->email}}
                        </div>

                        <div class="form-group">
                            <label>Division</label>
                           {{$user->division->name}}
                        </div>

                        <div class="form-group">
                            <label>Position</label>
                            {{$user->position->name}}
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input id="password" type="password" class="form-control" name="password"  />
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
