@extends('layouts.app')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
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
                        <th class="center">Name</th>
                        <th class="center">Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($divisions as $division)
                        <tr class="odd gradeX" align="center" id = "user_{{$division->id}}">
                            <td>{{$division->name}}</td>
                            <td>{{$division->description}}</td>
                            <td class="center"><i class="fa fa-trash-o fa-fw " ></i> <a href="{{route('admin.divisions.destroy', $division->id)}}" onclick="return confirm('Are you sure?')">delete</a></td>

                            <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{{route('admin.divisions.edit', $division->id)}}">edit</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <a href="{{route('admin.divisions.new')}}" class="btn btn-primary">Add Division</a>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->

    </div>
@endsection


@section('menu')

    @include('admin.menu')

@endsection