<div>
	<h1>List of users</h1>
	<div>
		<ul>
		<?php foreach ($usersList as $index => $value): ?>
			<li id="<?php echo $value['Users']['id'] ?>">
				<div>
					<b><?php echo $value['Users']['username'] ?></b>
					<p>Status: <?php if ($value['Users']['status'] == 1)
							echo 'Active'; ?></p>
				</div>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
</div>
<script>
	$(document).ready(function(){
		// var loginNa = "<?php echo $loginNa; ?>";
		
		// if (loginNa == 1) {
		// 	updateStatus();
		// }

		// var wsUri = "ws://localhost:9000/chat2/server.php"; 	
		// websocket = new WebSocket(wsUri); 
		
		// websocket.onopen = function(ev) {
		// 	console.log('onopen');
		// 	console.log(ev);
		// }

		// var objDiv = $('#message_box');
		// objDiv.scrollTop = objDiv.scrollHeight;
		// //prepare json data
		// var msg = {
		// 	message: mymessage,
		// 	name: myname
		// };
		// //convert and send data to server
		// websocket.send(JSON.stringify(msg));

		
		// //#### Message received from server?
		// websocket.onmessage = function(ev) {
		// 	console.log('onmessage');
		// 	var msg = JSON.parse(ev.data);
		// 	console.log(msg);
		// 	var type = msg.type;
		// 	var umsg = msg.message;
		// 	var uname = msg.name;
		// 	var ucolor = msg.color;

		// 	if(type == 'usermsg') {
				
		// 	}
		// 	if(type == 'system') {
		// 		// check for user status...
				
		// 	}
			
		// };
		
		// websocket.onerror = function(ev){
		// 	console.log('onerror');
		// }; 
		// websocket.onclose = function(ev){
		// 	console.log('onclose');
		// }; 

		// function updateStatus () {
		// 	$.ajax({
		// 		url: 'http://localhost:8012/chat2/users/getUsers/',
		// 		error: function (){},
		// 		success: function (data){
					
		// 		}
		// 	});
		// }

	});
</script>