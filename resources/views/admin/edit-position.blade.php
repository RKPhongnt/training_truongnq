@extends('layouts.app')

@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add new Position
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

                    <form method="POST" action="{{route('admin.positions.update', $position->id)}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" name="name" value="{{$position->name}}" placeholder="Please Enter Position Name" />
                        </div>

                        <div class="form-group">
                            <label>Level</label>
                            <input class="form-control" name="level" value="{{$position->level}}" placeholder="Please Enter Position Level" />
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <input class="form-control" name="description" value="{{$position->description}}" placeholder="Please Enter Division Description" />
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