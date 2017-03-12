<?php
include("config.php");
 
include('header.php');
?>
		
	<style>
		#pop{
			width: 960px; margin: 0px auto;
			margin-top:10px;
			margin-bottom:10px;
			border:2px solid;
			background:#FFFFFF;
		}
		#close{
			right:5px;
			top:5px;
			float:right;
			courser:pointer;
		}
		button{padding:5px; courser:pointer;}
	</style>
		<content>
			<div class="content_part">
			<div id="pop">
			<a href="view-member.php"><button id ="close" onclick="document.getElementById('pop').style.display='none'">X</button></a>
			
				<h2>Search Result of Member</h2>
<?php
include("config.php");	

if (isset($_POST['search'])) {
    $searchq =$_POST['search'];
	
	if(!(preg_match("/^[0-9]/", $searchq)))
	{
		echo '<br>You Press Wrong Keyword </br>';
	}
	$i=0;	
	$statement = $db->prepare("SELECT * FROM member_list WHERE member_id='$searchq' and mem_status='0'");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);	
	$num = $statement->rowCount();			
	
	if($num==0)
	{
		echo '<br>No Result Found</br>';
	}
	else
	{
		
	echo "<table class='tbl2' width='100%'>";
	echo '<p>&nbsp;</p><h4>Search of Member Id: '.$searchq.'</h4>';
		echo "<tr>"; 
		echo "<th width='5%'>Serial</th>"; 
		echo "<th width='10%'>Member Id</th>"; 
		echo "<th width='20%'>Photo</th>"; 
		echo "<th width='20%'>Name</th>"; 
		echo "<th width='20%'>Mobile</th>"; 
		echo "<th width='20%'>Action</th>"; 
		echo "</tr>";

			foreach($result as $row)
	
	{		
					
		$i++;
		?>
			
		<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $row['member_id'];; ?></td>
		<td><a href="../photo/member/<?php echo $row['mem_pic']; ?>"><img class="Pimg" src="../photo/member/<?php echo $row['mem_pic']; ?>" alt="" width="150" height="150"/></a></td>
		<td><?php echo $row['member_name']; ?></td>
		<td><?php echo $row['mem_mobile']; ?></td>
		<td>
			<a class="fancybox" href="#inline<?php echo $i; ?>">View</a>
		
	<div id="inline<?php echo $i; ?>" style="width:700px;display: none;">
			<div class="print">
				<a href="javascript:void(0)" onclick="PrintContent()">
				<p align="center"><b>Print</b></p></a>
			</div>
		<div id="prints">
				<h3 style="border-bottom:2px solid #808080;margin-bottom:10px;">View All Data</h3>
				<p>
					<form action="" method="post">
			
				
				
		<table class="tbl1">
		<tr>
			<td>Member Id: <?php echo $row['member_id'];?></td>
		</tr>
		<tr>
			<td>Employee Photo</td>
		</tr>
		<tr>
		<td><a href="../photo/member/<?php echo $row['mem_pic']; ?>"><img  src="../photo/member/<?php echo $row['mem_pic']; ?>" alt="Photo" width="230" height="220"/></a></td>
		</tr>
		<tr>
			<td>Username: <?php echo $row['mem_username'];?></td>
		</tr>
		<tr>
			<td>Name: <?php echo $row['member_name'];?></td>
		</tr>
		
		<tr>
			<td>Gender: <?php echo $row['mem_sex'];?></td>
		</tr>
		
		<tr>
			<td>Birthday: <?php echo $row['mem_birthday'];?></td>
		</tr>
	
		<tr>
			<td>Contact Number: <?php echo $row['mem_mobile'];?></td>
		</tr>
		
		<tr>
			<td>Address: <?php echo $row['mem_address'];?></td>
		</tr>			
		<tr>
			<td>Email: <?php echo $row['mem_email'];?></td>
		</tr>
		
		
				</p>
				</table>
				</form>
		</div>
	</div>
			&nbsp;|&nbsp;
			<a onclick='return confirm_message();' href="approved-member.php?member_id=<?php echo $row['member_id']; ?>"><img src="../images/edit.gif"></a>
			&nbsp;|&nbsp;
			<a onclick='return confirm_delete();' href="delete-member.php?member_id=<?php echo $row['member_id']; ?>"><img src="../images/delete.gif"></a></td>
		</tr>
		
		
		<?php
	}
	}
}
	?>
</table>
</br>
<a href="view-member.php"> Search Again </a>
</div>
</div>
		</content>

	<script type="text/javascript">
	function PrintContent()
	{
		var DocumentContainer = document.getElementById('prints');
		var WindowObject = window.open('', "PrintWindow", "width=595,height=842,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
		WindowObject.document.writeln(DocumentContainer.innerHTML);
		WindowObject.document.close();
		WindowObject.focus();
		WindowObject.print();
		WindowObject.close();
	}
	</script>
<?php include('footer.php');?>