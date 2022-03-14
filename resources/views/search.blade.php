@extends('layouts.base')

@section('session')
	@if( Session::has("status") )
		<div class="bg-dark text-danger center text-center">
			<div class="session-div">
				<span class="sz">{{Session::get("status")}}</span>
			</div>
		</div>
	@endif
@endsection

@section('secondNav')
	@include('inc.secondNav')
@endsection

@section('content')
	<div class="text-light center-div mt-4">
		<div class="all-tests-div bg-dark">
			<h1 class="text-center">Tests</h1>
			@if(count($tests) == 0)
				<a href="{{route('test.search')}}"><button class="btn btn-outline-light btn-lg">View All</button></a>
			@else
				@foreach($tests as $test)
					<a href="{{route('test.view', ['id'=>$test->id])}}" class="text-light"><button type="button" class="btn menu-btn btn-outline-light">{{$test->title}}</button></a>
				@endforeach
			@endif
		</div>
	</div>
	<script type="text/javascript" src="/js/search.js"></script>
@endsection