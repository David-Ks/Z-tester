@extends('layouts.base')

@section('haspass')
	@if($test->author != auth()->user()->name)
		@if($test->has_password)
			<div class="pass-div bg-dark">
				<div class="inner-pass-div pass-div-center text-light text-center">
					<div class="alert alert-danger error-div-fx" id="password-error">
					</div>
					<input class="form-control mb-4 inp-ft" id="test-pass" type="text" name="test-pass" placeholder="Password">
					<button type="button" class="btn btn-outline-light btn-lg btn mt-4" id="continue">Continue</button>
				</div>
			</div>
		@endif
	@endif
@endsection

@section('content')
	<div class="container-lg text-light test-hidden">
		@if($test->author == auth()->user()->name)
			<div class="block mt-5 bg-dark text-light">
				@if($test->has_password)
					<span class="content-sz">
						Password : {{$test->password}}
					</span>
					<br>
				@endif
				<a href="{{route('results', ['id'=>$test->id])}}"><button class="btn btn-outline-light">Results</button></a>
			</div>
		@endif
		<div class="block bg-dark mt-5 about">
			<h4 class="al-right">Created at: {{$test->created_at->format('j F, Y')}}</h4>
			<h2>Title: {{$test->title}}</h2>
			<h3>Author: {{$test->author}}</h3>
			<span class="content-sz">Content: {{$test->content}}</span>
		</div>
		<form method="POST">
			@csrf
			@for ($i = 1, $k = 1; $i < count($answers); $i+=8, $k++)
				<div class="block bg-dark mt-5 content-sz about">
					<h2>Question #{{$answers[$i]}}</h4>
					<span class="content-sz">{{$answers[$i + 1]}}</span>
					<?php
						$array = [];
						array_push($array, $answers[$i + 2]);
						array_push($array, $answers[$i + 3]);
						array_push($array, $answers[$i + 4]);
						array_push($array, $answers[$i + 5]);
						shuffle($array);
					?>
					@if($answers[$i + 6] == "true")
						<input class="form-control" type="text" name="answer{{$k}}" placeholder="True asnwer" aria-label="default input example">
					@else
						@for ($j = 1; $j < 5; $j++)
							<div class="form-check siz">
							  <input class="form-check-input" type="radio" name="answer{{$k}}" value="{{$array[$j - 1]}}" id="{{$i}}flexRadioDefault{{$j}}">
							  <label class="form-check-label" for="{{$i}}flexRadioDefault{{$j}}">
							    {{$array[$j - 1]}}
							  </label>
							</div>
						@endfor
					@endif
				</div>
			@endfor
			<div class="text-center mt-4">
				<button type="submit" class="btn menu-btn btn-outline-dark btn-lg mb-4">FINISH</button>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="/js/view.js"></script>
@endsection