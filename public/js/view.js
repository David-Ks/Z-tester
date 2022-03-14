$(document).ready(function () {
	let contBtn = $('#continue');
	let testHidden = $('.test-hidden');
	let passDiv = $('.pass-div');
	let passError = $('#password-error');

	if(Object.keys(contBtn).length === 0) {
		testHidden.show();
	}

	contBtn.on('click', function () {
		let testPass = $('#test-pass').val();
		$.ajax({
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: window.location.href,
            method: 'POST',
            data: {'pass': testPass},
            success: function(data) {
            	console.log(data.status);
            	if(data.status) {
            		testHidden.show();
            		passDiv.hide(100);
            	} else {
            		passError.show();
					passError.text('Password is not valid!');
            	}
            }
		});
	});
});
