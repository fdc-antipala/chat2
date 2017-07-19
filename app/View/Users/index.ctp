<div>
	<ul>
		<?php foreach($userlist as $index => $value): ?>
			<li>
				<div>
					<span style="display: none;" data-id="<?php echo $value['id'] ?>"></span>
					<b data-id="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></b>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
	<button id="login">Login</button>
	<button id="logout">Logout</button>
</div>
<?php echo $userID; ?>
<script>
	(function(){
		$(document).ready(function(){
			var HOST = window.location.host;
			var PATH = window.location.pathname;
			var BASEURL = HOST + PATH;
			var userID = "<?php echo $userID; ?>";
			var wsUri = "ws://localhost:9000/chat2/server.php"; 
			websocket = new WebSocket(wsUri);

			$('button#login').click(function(){
				sendMsg('login');
			});

			$('button#logout').click(function(){
				sendMsg('logout');
			});
			
			websocket.onopen = function(ev) {
				console.log('onopen');
			}

			function sendMsg (type) {
				//prepare json data
				var msg = {
					id: userID,
					name: 'John Doe',
					type: type
				};
				//convert and send data to server
				websocket.send(JSON.stringify(msg));
			}

			
			//#### Message received from server?
			websocket.onmessage = function(ev) {
				console.log('on message');
				var msg = JSON.parse(ev.data); //PHP sends Json data
				// console.log(msg.id);
				// console.log(msg.name);
				// console.log(msg.type);

				if (msg.type == 'login'){
					$('b').find('');
					$('b[data-id="' + msg.id +'"]').css('color', 'green');
					ajaCall('login', msg.id);

				}
				if (msg.type == 'logout'){
					$('b').find('');
					$('b[data-id="' + msg.id +'"]').css('color', 'gray');
					ajaCall('logout', msg.id);
				}
			};

			function ajaCall (flag, userID) {
				$.ajax({
					// url : BASEURL + 'users/loginLogout',
					url : 'http://localhost:8012/chat2/users/loginLogout',
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
</script>
