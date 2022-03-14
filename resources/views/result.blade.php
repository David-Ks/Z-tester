@extends('layouts.base')

@section('content')
	<div class="container block mt-5 bg-dark text-light">
		<div>
			<h3 class="text-center">Test results</h3>
			<h4 class="text-center">Title: {{$title}}</h4>
			<h4 class="text-center">Count: {{$count}}</h4>
			<table class="table text-light">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">User</th>
			      <th scope="col">Answers count</th>
			      <th scope="col">True answers count</th>
			      <th scope="col">Time</th>
			    </tr>
			  </thead>
			  <tbody>
				@foreach($results as $result)
					<tr>
				      <th scope="row">{{$result->id}}</th>
				      <td>{{$result->user}}</td>
				      <td>{{$result->answers_count}}</td>
				      <td>{{$result->true_answers_count}}</td>
				      <td>{{$result->created_at}}</td>
				    </tr>
				@endforeach
			  </tbody>
			</table>
		</div>
	</div>
@endsection