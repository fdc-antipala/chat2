(function(){
	$(document).ready(function(){
		var ORIGIN = window.location.origin;
		var PATH = window.location.pathname;
		var BASEURL = ORIGIN + '/chat2/';
		
		// var userID = "<?php echo $userID; ?>";
		// console.log(reqdata.loginSocket);
		var wsUri = "ws://localhost:9000/chat2/server.php"; 
		websocket = new WebSocket(wsUri);

		console.log(reqdata.loginSocket);
		
		setTimeout(function(){
			sendMsg(reqdata.loginSocket);
		},2000);

		$('button#login').click(function(){
			sendMsg('login');
		});

		$('a#logout').click(function(){
			sendMsg('logout');
		});
		
		websocket.onopen = function(ev) {
			console.log('onopen');
		}

		function sendMsg (type) {
			//prepare json data
			var msg = {
				id: 5,
				name: 'John Doe',
				type: type
			};
			//convert and send data to server
			websocket.send(JSON.stringify(msg));
		}

		/**
		 * Message received from server?
		 * login = 1, logout = 0;
		 */
		websocket.onmessage = function(ev) {
			console.log('on message');
			var msg = JSON.parse(ev.data);

			if (msg.type == 'login'){
				$('b').find('');
				$('b[data-id="' + msg.id +'"]').css('color', 'green');
				ajaCall(1, msg.id);
			}
			if (msg.type == 'logout'){
				$('b').find('');
				$('b[data-id="' + msg.id +'"]').css('color', 'gray');
				ajaCall(0, msg.id);
			}
		};

		function ajaCall (flag, userID) {
			$.ajax({
				url : BASEURL + 'users/loginLogout',
				type : 'POST',
				dataType : 'JSON',
				data : {
					'flag': flag,
					'userID': userID
				},
				success : function (data) {
					console.log(data);
				},
				error: function (e) {
					console.log('error');
				},

			});
		}
		
		websocket.onerror = function(ev){
			console.log('error');
		}; 
		websocket.onclose = function(ev){
			console.log('error');
		}; 
	});
})();