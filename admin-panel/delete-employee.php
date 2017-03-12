<?php

include("../config.php");
?>

<?php

if(isset($_REQUEST['employee_id'])) {

	$employee_id = $_REQUEST['employee_id'];


$statement = $db->prepare("DELETE FROM employee_list WHERE employee_id=?");
$statement->execute(array($employee_id));

$success_message2 = "Doctors Profile has been deleted successfully.";

}
?>


<?php include("header.php"); ?>
<div class="container">
	<div id="wrapper">
		<div id="container">
			<div id="sidebar">
				<ul class="navigation">
				<li class="highlight"><a href="index.php" class="button button-green">Dashboard</a></li>
				<li><a href="add-employee.php" class="button button-red">Add Employee</a></li>
				<li><a href="add-designation.php" class="button button-blue">Add/View Designation</a></li>
				<li><a href="view-employee.php" class="button button-green">View/Edit Employee</a></li>
				<li><a href="delete-employee.php" class="button button-orange">Delete Employee</a></li>
				<li><a href="logout.php" class="button button-gray">Logout</a></li>
				</ul>
				<p>&nbsp;</p>
			</div>
		<div id="content">
<h2>View  All Doctors</h2>
<p>&nbsp;</p>
<?php
if(isset($success_message2)) {echo "<div class='success'>".$success_message2."</div>";}
?>
<table class="tbl2" width="100%">
	<tr>
		<th width="5%">Serial</th>
		<th width="25%">Photo</th>
		<th width="15%">Username</th>
		<th width="20%">Designation</th>
		<th width="15%">Action</th>
	</tr>
	
<?php
		/* ===================== Pagination Code Starts ================== */
		$adjacents = 7;
								
		$i=0;
		$statement = $db->prepare("SELECT employee_designation.designation,employee_id,employee_pic,employee_name,employee_username,sex,birthday,joining_date,salary,email,duty_hour,off_day,account_number,address,account_number,contact_number FROM employee_designation,employee_list WHERE  employee_designation.designation_id=employee_list.designation_id ORDER BY employee_id DESC");
		$statement->execute();
		$total_pages = $statement->rowCount();
	
			$targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
			$limit = 50;                                 //how many items to show per page
			$page = @$_GET['page'];
			if($page) 
				$start = ($page - 1) * $limit;          //first item to display on this page
			else
				$start = 0;
			
			$statement = $db->prepare("SELECT employee_designation.designation,employee_id,employee_pic,employee_name,employee_username,sex,birthday,joining_date,salary,email,duty_hour,off_day,account_number,address,account_number,contact_number FROM employee_designation,employee_list WHERE  employee_designation.designation_id=employee_list.designation_id ORDER BY employee_id DESC LIMIT $start, $limit");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);		
			
			if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
			$prev = $page - 1;                          //previous page is page - 1
			$next = $page + 1;                          //next page is page + 1
			$lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
			$lpm1 = $lastpage - 1;   
			$pagination = "";
			if($lastpage > 1)
			{   
				$pagination .= "<div class=\"pagination\">";
				if ($page > 1) 
					$pagination.= "<a href=\"$targetpage?page=$prev\">&#171; previous</a>";
				else
					$pagination.= "<span class=\"disabled\">&#171; previous</span>";    
				if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
				{   
					for ($counter = 1; $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
					}
				}
				elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
				{
					if($page < 1 + ($adjacents * 2))        
					{
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
					}
					elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
					{
						$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
						$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
						$pagination.= "...";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
					}
					else
					{
						$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
						$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
						$pagination.= "...";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
					}
				}
				if ($page < $counter - 1) 
					$pagination.= "<a href=\"$targetpage?page=$next\">next &#187;</a>";
				else
					$pagination.= "<span class=\"disabled\">next &#187;</span>";
				$pagination.= "</div>\n";       
			}
			/* ===================== Pagination Code Ends ================== */	
	
	foreach($result as $row)
	
	{		
					
					$employee_pic = $row['employee_pic'];
					$name = $row['employee_name'];
					$sex = $row['sex'];
					$birthday = $row['birthday'];
					$joining_date = $row['joining_date'];
					$salary = $row['salary'];
					$designation = $row['designation'];
					$duty_hour = $row['duty_hour'];
					$off_day = $row['off_day'];
					$account_number = $row['account_number'];
					$contact_number = $row['contact_number'];
					$address = $row['address'];
					$email = $row['email'];
		$i++;
		?>
			
		<tr>
		<td><?php echo $i; ?></td>
		<td><a href="../uploads/<?php echo $row['employee_pic']; ?>"><img class="Pimg" src="../uploads/<?php echo $row['employee_pic']; ?>" alt="" width="150" height="150"/></a></td>
		<td><?php echo $row['employee_username']; ?></td>
		<td><?php echo $row['designation']; ?></td>
		<td>
			<a class="fancybox" href="#inline<?php echo $i; ?>">View</a>
			<div id="inline<?php echo $i; ?>" style="width:700px;display: none;">
				<h3 style="border-bottom:2px solid #808080;margin-bottom:10px;">View Employee</h3>
				<p>
					<form action="" method="post">
			
				
				
		<table class="tbl1">
		<tr>
			<td>Employee Photo</td>
		</tr>
		<tr>
		<td><a href="../uploads/<?php echo $row['employee_pic']; ?>"><img  src="../uploads/<?php echo $row['employee_pic']; ?>" alt="Photo" width="230" height="220"/></a></td>
		</tr>
		<tr>
			<td>Name: <?php echo $name;?></td>
		</tr>
	
		<tr>
			<td>Gender: <?php echo $sex;?></td>
		</tr>
		
		</tr>
		<tr>
			<td>Birthday: <?php echo $birthday;?></td>
		</tr>
	
		<tr>
			<td>Designation: <?php echo $designation;?></td>
		</tr>

		<tr>
			<td>Joining Date: <?php echo $joining_date;?></td>
		</tr>
		<tr>
			<td>Net Salary: <?php echo $salary;?></td>
		</tr>
		<tr>
			<td>Duty Hours: <?php echo $duty_hour;?></td>
		</tr>
		
		<tr>
			<td>Off Day: <?php echo $off_day;?></td>
		</tr>
	
		<tr>
			<td>Account Number: <?php echo $account_number;?></td>
		</tr>
		
		<tr>
			<td>Contact Number: <?php echo $contact_number;?></td>
		</tr>
		
		<tr>
			<td>Address: <?php echo $address;?></td>
		</tr>			
		<tr>
			<td>Email: <?php echo $email;?></td>
		</tr>
				</p>
				</table></form>
	</div>
			&nbsp;|&nbsp;
			<a onclick='return confirm_delete();' href="delete-employee.php?employee_id=<?php echo $row['employee_id']; ?>"><img src="img/delete.gif"></a>
		</tr>
		
		<?php
	}
	?>
	
</table>
			</div>
		</div>
	</div>
</div>

<div class="pagination">
<?php 
echo $pagination; 
?>
</div>

</br></br>

<?php include("footer.php"); ?>			