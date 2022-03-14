@extends('layouts.base')

@section('content')
	<div class="container">
		<div>
			<div class="block bg-dark text-light mt-5 row">
				<div class="d-sz">
					<h3>Your Profile</h3>
					<p>User ID : {{$user->id}}</p>
					<p>Name : {{$user->name}}</p>
					<p>E-mail : {{$user->email}}</p>
					<p>Created at : {{$user->created_at}}</p>
				</div>
			</div>	
		</div>	
		<div class="block bg-dark text-light mt-3 row">
			<div class="d-sz">
				<h3>Your Tests</h3>
				@foreach($tests as $test)
					<a href="{{route('test.view', ['id'=>$test->id])}}" class="text-light"><button type="button" class="btn menu-btn btn-outline-light">{{$test->title}}</button></a>
				@endforeach
			</div>
		</div>
	</div>

		
@endsection