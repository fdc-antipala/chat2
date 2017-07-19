<div class="content_wrapper <?php echo $this->params['controller']; ?>">
	<div class="left">
		<div class="profile">
			<div class="profile_image">
				<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRWZpYwZndqvYmZN698HlAncwJ0YvkbGqZ1UO4JXZIGQNFgjt66dgfNjg">
			</div>
			<div class="profile_details">
				<b>Jake Zyruz</b>
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
								data-status-flag="<?php echo ($value['status']) ? 1 : 0; ?>">
									<?php echo $value['name'] ?>
								</b>
							</div>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="right">
		<b>sample</b>
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