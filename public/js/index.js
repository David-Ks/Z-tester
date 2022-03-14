$(document).ready(function () {
	let session = $('.session-div');

	function hideSession() {
		session.hide(500);
	}

	if (session.length != 0) {
		setTimeout(hideSession, 5000);
	}
	console.log(session);
});