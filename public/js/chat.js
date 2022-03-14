$(document).ready(function () {
	let area = $("#chat-area");
	let btn = $("#chat-btn");

	btn.on('click', function() {
		let input = $("#chat-inp");

		$.ajax({
			url: window.location.href,
			type: 'GET',
			data: {
				'inputText': input.val()
			},
			success: function(data) {
				input.val('');
			}
		});
	});

	async function chatUpload() {
		$.ajax({
			url: window.location.href,
			type: 'GET',
			data: {
				'getChatInfo': 1
			},
			success: function(data) {
				let chat = data.chats;
				chat.map(el => {
					chat[chat.indexOf(el)] = el.author + ': ' + el.text;
				});
				area.val(chat.join('\n'));
			},
			error: function() {
				console.log('Error');
			}
		});
	}
	setInterval(function() {chatUpload();}, 2000);
});