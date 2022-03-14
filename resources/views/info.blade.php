@extends('layouts.base')

@section('content')
<div class="container mt-4">
	<div class="bg-dark text-light block text-center mt-4 row">
		<h1>Results</h1>
		<span class="content-sz">
			Title: {{$test->title}}<br>
			Author: {{$test->author}}<br>
			Time: {{$test->created_at->format('j F, Y')}}<hr>
		</span>
		@if(Session::has('status'))
			<span class="content-sz">
				{{Session::get('status')}}
			</span>
		@else
			No results
		@endif
	</div>
	<div class="row text-center mt-4">
		<a href="{{route('home')}}"><button class="btn btn-lg btn-outline-dark more-btn">Back</button></a>
	</div>
</div>
@endsection