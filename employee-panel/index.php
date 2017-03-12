<?php include('header.php');?>
		
		<content>
			<div class="content_part">
				<div class="content_part_left">
					<?php include('sidebar-menu.php');?>
				</div>
				<div class="content_part_right">
					<h1>Welcome To Our City Restaurant</h1>
					<div class="count_btn">
					<div class="pending_btn">
						<?php include('count-unread-message.php');?>
						</div>
						<div class="successful_btn">
						<?php include('count-read-message.php');?>
						</div>
					</div>
				</div>
			</div>
		</content>
<?php include('footer.php');?>