@extends('layouts.base')

@section('secondNav')
    @include('inc.secondNav')
@endsection

@section('session')
	@if( Session::has("status") )
		<div class="bg-dark text-light center text-center">
			<div class="session-div">
				<span class="sz">{{Session::get("status")}}</span>
			</div>
		</div>
	@endif
@endsection

@section('content')
	<div class="container-lg">
		<div class="row justify-content-around content-div">
			<div class="col-lg-6 text-light">
				<div class="bg-dark first-div faz">
					<h1 class="h1 mt-4 text-center">Most popular tests</h1>
					<div class="text-center">
						@foreach($tests as $test)
							<a href="/test/{{$test->id}}"><button type="button" class="btn menu-btn btn-widht btn-outline-light">
								{{ \Illuminate\Support\Str::limit($test->title, 5) }}
							</button></a>
						@endforeach
					</div>
				</div>
				<div class="bg-dark second-div">
					<h2 class="h2 mt-4">Test</h2>
					<figure class="text-center hel-txt">
					  <figcaption class="blockquote-footer">
					    "It’s not about how bad you want it, it’s about how hard you are willing to work for it."
					  </figcaption>
					</figure>
				</div>
			</div>
			<div class="col-6 for-ph-crausel">
				@include('inc.crausel')
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3 justify-content-around">
				<div class="last-content-div-btn bg-dark text-light text-center">
					<h3 class="h3 mt-4">Create your test!</h3>
					<a href="{{route('create')}}"><button type="button" class="btn mb-4 mt-4 btn-outline-light btn-lg ml-1">CREATE</button></a>
				</div>
			</div>
			<div class="col last-content-div bg-dark text-light">
				<textarea class="form-control resize-none" rows="5" id="chat-area" disabled></textarea>
				@auth
					<div class="chat-div">
						<input class="form-control mt-1 chat-inp" id="chat-inp" type="text" name="chat-inp">
						<button class="btn btn-outline-light chat-btn mt-1" type="button" id="chat-btn">Send</button>
					</div>
				@else
					<div class="chat-div">
						<input class="form-control mt-1 chat-inp" id="chat-inp" type="text" placeholder="Log in to use chat!" name="chat-inp" disabled>
						<button class="btn btn-outline-light chat-btn mt-1" type="button" id="chat-btn" disabled>Send</button>
					</div>
				@endauth
			</div>
		</div>
	</div>
	<script type="text/javascript" src="/js/index.js"></script>
@endsection