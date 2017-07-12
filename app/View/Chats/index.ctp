<?php 
$colours = array('007AFF','FF7000','FF7000','15E25F','CFC700','CFC700','CF1100','CF00BE','F00');
$user_colour = array_rand($colours);
?>
<div>
	<h1>Chats</h1>
	<div class="chat_wrapper">
		<div class="message_box" id="message_box"></div>
		<div class="panel">
		<input type="text" name="name" id="name" placeholder="Your Name" maxlength="15" />

		<!-- <input type="text" name="message" id="message" placeholder="Message" maxlength="80" 
		onkeydown = "if (event.keyCode == 13)document.getElementById('send-btn').click()"  /> -->
		<textarea name="message" id="message" placeholder="Message" onkeydown = "if (event.keyCode == 13)document.getElementById('send-btn').click()"></textarea>
		</div>
		<button id="send-btn" class=button>Send</button>
	</div>
</div>


<script language="javascript" type="text/javascript">  
$(document).ready(function(){
	//create a new WebSocket object.
	var wsUri = "ws://localhost:9000/chat2/server.php"; 	
	websocket = new WebSocket(wsUri); 
	
	websocket.onopen = function(ev) {
		$('#message_box').append("<div class=\"system_msg\">Connected!</div>"); //notify user
	}

	$('#send-btn').click(function() {
		var mymessage = $('#message').val();
		var myname = $('#name').val();
		
		if(myname == "") {
			alert("Enter your Name please!");
			return;
		}
		if(mymessage == "") {
			alert("Enter Some message Please!");
			return;
		}
		document.getElementById("name").style.visibility = "hidden";
		
		var objDiv = document.getElementById("message_box");
		objDiv.scrollTop = objDiv.scrollHeight;
		//prepare json data
		var msg = {
		message: mymessage,
		name: myname,
		color : '<?php echo $colours[$user_colour]; ?>'
		};
		//convert and send data to server
		websocket.send(JSON.stringify(msg));
	});
	
	//#### Message received from server?
	websocket.onmessage = function(ev) {
		var msg = JSON.parse(ev.data); //PHP sends Json data
		var type = msg.type; //message type
		var umsg = msg.message; //message text
		var uname = msg.name; //user name
		var ucolor = msg.color; //color

		if(type == 'usermsg') 
		{
			$('#message_box').append("<div><span class=\"user_name\" style=\"color:#"+ucolor+"\">"+uname+"</span> : <span class=\"user_message\">"+umsg+"</span></div>");
		}
		if(type == 'system')
		{
			$('#message_box').append("<div class=\"system_msg\">"+umsg+"</div>");
		}
		
		$('#message').val(''); //reset text
		
		var objDiv = document.getElementById("message_box");
		objDiv.scrollTop = objDiv.scrollHeight;
	};
	
	websocket.onerror	= function(ev){$('#message_box').append("<div class=\"system_error\">Error Occurred - "+ev.data+"</div>");}; 
	websocket.onclose 	= function(ev){$('#message_box').append("<div class=\"system_msg\">Connection Closed</div>");}; 
});
</script>