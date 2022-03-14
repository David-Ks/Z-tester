@extends('layouts.base')


@section('content')
	<div class="container-lg create-div">
		<div class="form-div static-size bg-dark text-light">
			<form method="POST" enctype="multipart/form-data">
				<div class="mb-3">
			    	<label for="title" class="form-label sz title-sz mt-2">Test title</label>
			    	<div class="alert alert-danger error-div-f" id="title-error">
				    </div>
				    <input type="text" class="form-control" id="title" placeholder="Test title">
				</div>

				<div class="mb-3">
				    <label for="content" class="form-label sz mt-3">About test</label>
				    <div class="alert alert-danger error-div-f" id="content-error">
				    </div>
				    <textarea type="text" class="form-control" id="content" rows="11" placeholder="About your test"></textarea>
				</div>
				<div class="form-check form-switch sz-switch right">
				  <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
				  <label class="form-check-label mt-lab" for="flexSwitchCheckChecked">With password?</label>
				</div>
				<div class="mb-3 hide-div">
			    	<label for="pass" class="form-label mt-4">Test password</label>
			    	<div class="alert alert-danger error-div-f" id="password-error">
				    </div>
				    <input type="password" class="form-control sz" id="pass" placeholder="Password">
				    <div id="passHelp" class="form-text">Enter your test password.</div>
				</div>
			</form>
		</div>
		<div class="next-btn-div">
			<button type="button" class="btn next-btn btn-outline-dark btn-lg">Next Step</button>
		</div>
		<div class="answers-div">		
		</div>
		<div class="center-div mb-4">
			<button type="button" class="btn new-btn more-btn btn-outline-dark  btn-lg">New</button>
			<button type="button" class="btn create-btn more-btn btn-outline-dark  btn-lg">Create</button>
		</div>
	</div>
	
	<script type="text/javascript" src="/js/create.js"></script>
@endsection