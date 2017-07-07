@extends('app')

@section('content')

@if(count($developer))

<h1>About developer</h1>
<ul> @foreach ($developer as $person)
		<li>{{ $person }}</li>
	 @endforeach
</ul>

@endif

@stop


@section('footer')

@stop