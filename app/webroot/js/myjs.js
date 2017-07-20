(function(){
	
	$(document).ready(function(){

		var idleTime = 0;
		function timerIncrement() {
			idleTime = idleTime + 1;
			if (idleTime > 10) { // 5 minutes
				sendMsg('logout');
				// testetsets
			}
		}

		//Increment the idle time counter every minute.
		var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

		//Zero the idle timer on mouse movement.
		$(this).mousemove(function (e) {
		idleTime = 0;
		});
		$(this).keypress(function (e) {
			idleTime = 0;
		});

		var ORIGIN = window.location.origin;
		var PATH = window.location.pathname;
		var BASEURL = ORIGIN + '/chat2/';
		
		var wsUri = "ws://localhost:9000/chat2/server.php"; 
		websocket = new WebSocket(wsUri);
		console.log(reqdata.userID);

		updateLastOnline();
		setTimeout(function(){
			sendMsg(reqdata.loginSocket);
		},2000);

		setTimeout(function(){

		},5 * 60 * 1000);


		$('a#logout').click(function(){
			sendMsg('logout');
		});
		
		websocket.onopen = function(ev) {
			console.log('onopen');
		}

		function sendMsg (type) {
			//prepare json data
			var msg = {
				id: reqdata.userID,
				name: 'John Doe',
				type: type,
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
			console.log(msg.id);
			if (msg.type == 'login'){
				$('b').find('');
				$('b[data-id="' + msg.id +'"]').css('color', 'green');
				if (msg.id == reqdata.userID)
					ajaCall(1, msg.id);
			}
			if (msg.type == 'logout'){
				$('b').find('');
				$('b[data-id="' + msg.id +'"]').css('color', 'gray');
				if (msg.id == reqdata.userID)
					ajaCall(0, msg.id);
			}

			// query database...
		};

		/**
		 * Query database to update status
		 * @param  {int} flag   [description]
		 * @param  {int} userID [description]
		 */
		function ajaCall (flag, userID) {
			console.log('ajaxcall');
			$.ajax({
				url : BASEURL + 'users/loginLogout',
				type : 'POST',
				dataType : 'JSON',
				data : {
					'flag': flag,
					'userID': userID,
					'from' : reqdata.userID
				},
				success : function (data) {
					console.log(data);
				},
				error: function (e) {
					console.log('error');
				},

			});
		}

		/**
		 * Update user last login time...
		 * to identify users that are still online
		 */
		function updateLastOnline () {
			$.ajax({
				url : BASEURL + 'users/updateLastOnline',
				type : 'POST',
				dataType : 'JSON',
				data : {'userID': reqdata.userID},
				success : function (data) {
					console.log(data);
				},
				error: function (e) {console.log(e);},
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