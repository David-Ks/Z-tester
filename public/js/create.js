$(document).ready(function () {
	let nextBtn = $(".next-btn");
	let newBtn = $(".new-btn");
	let createBtn = $(".create-btn");
	let answerDiv = $(".answers-div");
	let showAndHidePass = $("#flexSwitchCheckChecked");
	let passDiv = $(".hide-div");

	let answers = 0
	let delAnswers = [];


	function newQuestion(answers) {
		answerDiv.append(`<div id='div${answers}' class='answer-content-div mt-4 bg-dark text-light'></div>`);
		let div = $(`#div${answers}`);
			
		div.append(`<div class="alert alert-danger error-div-fx" id="answer${answers}-error"></div>
			<div class='answers-group-div'><button type="button" id="${answers}" class="btn delete-btn btn-light btn-outline-danger">X</button></div>`);

		div.append(`<div class='answers-group-div'><label for="question${answers}" class="form-label sz-answer">Question</label>
		<input type="text" class="form-control inp-answer quest-answer" id="question${answers}" placeholder="Question" required></div>`);

		div.append(`<div class='answers-group-div'><label for="true${answers}" class="form-label sz-answer">True answer</label>
		<input type="text" class="form-control inp-answer true-answer" id="true${answers}" placeholder="True answer" required></div>`);

		for(let i=1; i<4; i++) {
			div.append(`<div class='answers-group-div' id="${i}falseLabel${answers}""><label for="${i}false${answers}" class="form-label sz-answer">False answer #${i}</label>
		<input type="text" class="form-control inp-answer false-answer" id="${i}false${answers}" placeholder="False answer ${i}" required></div>`);
		}

		div.append(`
			<div class='answers-group-div sz-switch'>
				<div class="form-check form-switch chek-wr-div sz-switch" id='${answers}'>
				    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked-${answers}" checked>
				    <label class="form-check-label mt-lab" for="flexSwitchCheckChecked-${answers}">Whrite answer?</label>
				</div>
			</div>`);

		$(`#flexSwitchCheckChecked-${answers}`)[0].checked = false;

		$(".delete-btn").on("click", function(el) {
			$(`#div${el.target.id}`).remove();
			delAnswers.push(+el.target.id);
			if (answerDiv.children().length == 0) {
				nextBtn.fadeIn(0);
				newBtn.fadeOut(0);
				createBtn.fadeOut(0);
			} else {
				nextBtn.fadeOut(0);
			}
		});

		$('.chek-wr-div').on('click', function (el) {
			let answerId = el.target.id.split('-')[1];
			if(el.target.checked) {
				for(let i=1; i<4; i++) {
					$(`#${i}falseLabel${answerId}`).hide(600);
					$(`#${i}false${answerId}`).val(`no${i}`);
				}
			} else {
				for(let i=1; i<4; i++) {
					$(`#${i}falseLabel${answerId}`).show(600);
					$(`#${i}false${answerId}`).val('');
				}
			}
		});
	}

	showAndHidePass[0].checked = false;
	showAndHidePass.on("click", function(el) {
		if(el['originalEvent'].target.checked) {
			passDiv.fadeIn();
		} else {
			passDiv.fadeOut(0);
		}
	});

	nextBtn.on("click", function () {
		answers++;
		nextBtn.fadeOut(0);
		newBtn.fadeIn();
		createBtn.fadeIn();
		newQuestion(answers);
	});

	newBtn.on("click", function() {
		answers++;
		newQuestion(answers);
	});

	createBtn.on("click", function() {		
		let title = $("#title").val();
		let content = $("#content").val();
		let hasPass = (showAndHidePass[0].checked ? 1 : 0);
		let pass = 0;
		if (hasPass) {
			pass = $("#pass")[0].value;
		}
		let answ = '';
		let BreakFlag = false;
		for (let i=1; i<=answers; i++) {
			if(delAnswers.includes(i)){
				continue;
			}
			let trueAnswer = $(`#true${i}`)[0].value;
			let FalseAnswer1 = $(`#1false${i}`)[0].value;
			let FalseAnswer2 = $(`#2false${i}`)[0].value;
			let FalseAnswer3 = $(`#3false${i}`)[0].value;
			if($(`#div${i}`).length) {

				// Oops!
				if  (
					trueAnswer == FalseAnswer1 || 
					trueAnswer == FalseAnswer2 || 
					trueAnswer == FalseAnswer3 ||
					FalseAnswer1 == FalseAnswer2 ||
					FalseAnswer1 == FalseAnswer3 ||
					FalseAnswer2 == FalseAnswer3 ||
					trueAnswer == '' || FalseAnswer1 == '' ||
					FalseAnswer2 == '' || FalseAnswer3 == ''
					) 
				{
					$(`#answer${i}-error`).show();
					$(`#answer${i}-error`).text('- Answers should not be repeated. Answer fields are required. ');
					BreakFlag=true;
				} else {
					$(`#answer${i}-error`).hide();
					$(`#answer${i}-error`).text('');
				}

				answ += '~F';
				answ += i + '~D';
				answ += $(`#question${i}`)[0].value + '~D';
				answ += $(`#true${i}`)[0].value + '~D';
				for (let j=1; j<4; j++) {
					answ += $(`#${j}false${i}`)[0].value + '~D';
				}
				answ += $(`#flexSwitchCheckChecked-${i}`)[0].checked + '~D';
			}
		}
		if (BreakFlag) {
			BreakFlag=false;
			return 0;
		}
		$.ajax({
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
			url: window.location.href,
			type: 'POST',
			data: {
				'title': title,
				'content': content,
				'hasPass': hasPass,
				'pass': pass,
				'answ': answ,
			},
			success: function(data) {
				window.location.href = `/`;
				console.log('OK!');
			},
			error: function(response) {
				/*
		    <div class="alert alert-danger">
		        <ul>
		        	aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
				*/
				let arr = Object.keys(response.responseJSON.errors);
				arr.forEach(el => {
					console.log(arr)
					if(el == 'title') {
						$('#title-error').show();
						$('#title-error').text(response.responseJSON.errors['title'][0]);
					}
					if(el == 'content') {
						$('#content-error').show();
						$('#content-error').text(response.responseJSON.errors['content'][0]);
					}
					if(el == 'pass') {
						$('#password-error').show();
						$('#password-error').text(response.responseJSON.errors['pass'][0]);
					}
				});
				if(!(arr.includes('title'))) {
					$('#title-error').hide();
					$('#title-error').text('');
				}
				if(!(arr.includes('content'))) {
					console.log('fff')
					$('#content-error').hide();
					$('#content-error').text('');
				}
				if(!(arr.includes('pass'))) {
					console.log('fff')
					$('#password-error').hide();
					$('#password-error').text('');
				}
			}
		});

	});
});