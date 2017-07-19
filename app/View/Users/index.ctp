<div>
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
<?php if (!isset($loginSocket)):
	$_loginSocket = 'null';
	else:
		$_loginSocket = $loginSocket;
	endif; ?>
<script type="text/javascript">var reqdata = {userID: "<?= $userID; ?>", loginSocket: "<?= $_loginSocket; ?>"};</script>
<!-- <script type="text/javascript">var userID = "<?= $userID; ?>";</script> -->
<?php echo $this->Html->script('myjs'); ?>