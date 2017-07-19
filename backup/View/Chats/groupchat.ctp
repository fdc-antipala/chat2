<?php 
$colours = array('007AFF','FF7000','FF7000','15E25F','CFC700','CFC700','CF1100','CF00BE','F00');
$user_colour = array_rand($colours);
?>
<div>
	<h1>Chats</h1>
	<div class="chat_wrapper">
		<div class="message_box" id="message_box"></div>
		<div class="panel">
		<textarea name="message" id="message" placeholder="Message"></textarea>
		</div>
		<button id="send-btn" class=button>Send</button>
	</div>
</div>

<script>
	$(document).ready(function(){

		function getCaret(el) {
			if (el.selectionStart) {
				return el.selectionStart;
			} else if (document.selection) {
				el.focus();
				var r = document.selection.createRange();
				if (r == null) {
					return 0;
				}
				var re = el.createTextRange(), rc = re.duplicate();
				re.moveToBookmark(r.getBookmark());
				rc.setEndPoint('EndToStart', re);
				return rc.text.length;
			}
			return 0;
		}
		$('textarea#message').keyup(function(event){
			if (event.keyCode == 13) {
				var content = this.value;
				var caret = getCaret(this);
				if(event.shiftKey){
					this.value = content.substring(0, caret - 1) + "\n" + content.substring(caret, content.length);
					event.stopPropagation();
				} else {
					this.value = content.substring(0, caret - 1) + content.substring(caret, content.length);
					$('#send-btn').click();
				}
			}
		});

		//create a new WebSocket object.
		var wsUri = "ws://localhost:9000/chat2/server.php"; 
		websocket = new WebSocket(wsUri); 
		var username = "<?php echo $username; ?>";
		console.log(username);
		
		websocket.onopen = function(ev) {
			// $('#message_box').append("<div class=\"system_msg\">Connected!</div>"); //notify user
			console.log('open');
		}

		$('#send-btn').click(function() {
			var mymessage = $('#message').val();
			var myname = username;
			
			// if(myname == "") {
			// 	alert("Enter your Name please!");
			// 	return;
			// }
			if(mymessage == "") {
				alert("Enter Some message Please!");
				return;
			}

			// $('#name').css("visibility","hidden");
			
			// var objDiv = $('#message_box');
			// objDiv.scrollTop = objDiv.scrollHeight;
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
			console.log(ev);
			var msg = JSON.parse(ev.data); //PHP sends Json data
			var type = msg.type; //message type
			var umsg = msg.message; //message text
			var uname = msg.name; //user name
			var ucolor = msg.color; //color

			if(type == 'usermsg') {
				$('#message_box').append("<div><span class=\"user_name\" style=\"color:#"+ucolor+"\">"+uname+"</span> : <span class=\"user_message\">"+umsg+"</span></div>");
			}
			if(type == 'system') {
				$('#message_box').append("<div class=\"system_msg\">"+umsg+"</div>");
			}
			
			$('#message').val(''); //reset text
			
			var objDiv = $('#message_box');
			objDiv.scrollTop = objDiv.scrollHeight;
		};
		
		websocket.onerror = function(ev){
			console.log('error');
			// $('#message_box').append("<div class=\"system_error\">Error Occurred - "+ev.data+"</div>");
		}; 
		websocket.onclose = function(ev){
			console.log('close');
			// $('#message_box').append("<div class=\"system_msg\">Connection Closed</div>");
		}; 
	});
</script>