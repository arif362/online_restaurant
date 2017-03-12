<?php

include("config.php");
?>

		
		<content>
			<div class="content_part">
				<div class="content_part_left">
				
				</div>
				<div class="content_part_right">
					<?php include('view-inbox-message.php');?>
					</br>
					<?php include('view-send-message.php');?>
				</div>
			</div>


<div class="pagination">
<?php 
echo $pagination; 
?>
</div>
		</content>
		
	<script type="text/javascript">
	function PrintContent()
	{
		var DocumentContainer = document.getElementById('prints');
		var WindowObject = window.open('', "PrintWindow", "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
		WindowObject.document.writeln(DocumentContainer.innerHTML);
		WindowObject.document.close();
		WindowObject.focus();
		WindowObject.print();
		WindowObject.close();
	}
	</script>
