<?php 
date_default_timezone_set('Asia/Manila');
// $theTime = strtotime('2017-07-20 13:58:32');
// echo $theTime < strtotime('-5 minutes') ? 'aaa' : 'bbb';

	// if ($theTime < strtotime('-5 minutes'))
	// 	echo 'aaa';
	// else
	// 	echo 'bbb';
?>
<div class="content_wrapper <?php echo $this->params['controller']; ?>">
	<div class="row">
		<div class="left col-md-4">
			<div class="profile">
				<div class="profile_image">
					<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRWZpYwZndqvYmZN698HlAncwJ0YvkbGqZ1UO4JXZIGQNFgjt66dgfNjg">
				</div>
				<div class="profile_details">
					<b><?php echo $userName; ?></b>
					<p>Sample, sample ra.</p>
				</div>
			</div>
			<div class="contacts">
				<ul>
					<?php foreach($userlist as $index => $value): ?>
						<li>
							<a href="">
								<div>
									<span style="display: none;" data-id="<?php echo $value['id'] ?>"></span>
									<b data-id="<?php echo $value['id'] ?>"
									data-status-flag="<?php $theTime = strtotime($value['last_login_time']);
									echo $theTime < strtotime('-10 minutes') ? '0' : '1'; ?>"
									data-flag="<?php 
									$theTime = strtotime($value['last_login_time']);
									echo $theTime < strtotime('-5 minutes') ? 'offline' : 'online'; ?>">
										<?php echo $value['name'] ?>
									</b>
								</div>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<div class="right col-md-8">
			<b>sample</b>
		</div>
	</div>
</div>
<?php if (!isset($loginSocket)):
	$_loginSocket = 'null';
	else:
		$_loginSocket = $loginSocket;
	endif; ?>
<script type="text/javascript">var reqdata = {userID: "<?= $userID; ?>", loginSocket: "<?= $_loginSocket; ?>"};</script>
<!-- <script type="text/javascript">var userID = "<?= $userID; ?>";</script> -->
<?php echo $this->Html->script('myjs'); ?>