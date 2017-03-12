
<?php
include('config.php');

if(isset($_POST['form1']))
{
	try {
		
		if(empty($_POST['designation'])) {
			throw new Exception("Disease designation Name can not be empty.");
		}
		
		$statement = $db->prepare("SELECT * FROM employee_designation WHERE designation=?");
		$statement->execute(array($_POST['designation']));
		$total = $statement->rowCount();
		
		if($total>0) {
			throw new Exception("Designation Name already exists.");
		}
		$add_date = date('d-m-Y H:i:s', time());
		
		$statement = $db->prepare("INSERT INTO employee_designation (designation,add_date) VALUES (?,?)");
		$statement->execute(array($_POST['designation'],$add_date));
		
		$success_message = "Designation name has been inserted successfully.";
		
	
	}
	
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
} 
if(isset($_POST['form2']))
{
	try {
		
		if(empty($_POST['designation'])) {
			throw new Exception("Disease designation Name can not be empty.");
		}
		
		$statement = $db->prepare("UPDATE employee_designation SET designation=? WHERE designation_id=?");
		$statement->execute(array($_POST['designation'],$_POST['hdn']));
		
		$success_message1 = "Employee designation Name has been updated successfully.";
		
	}
	catch(Exception $e) {
		$error_message1 = $e->getMessage();
	}
		
}

if(isset($_REQUEST['designation_id'])) 
{
	$id = $_REQUEST['designation_id'];
	
	$statement = $db->prepare("DELETE FROM employee_designation WHERE designation_id=?");
	$statement->execute(array($id));
	
	$success_message2 = "Employee Designation has been deleted successfully.";
	
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
				<h2>Add Designation</h2>
				<p>&nbsp;</p>
				<?php
				if(isset($error_message)) {echo "<div class='error'>".$error_message."</div>";}
				if(isset($success_message)) {echo "<div class='success'>".$success_message."</div>";}
				?>
				<form action="" method="post">
					<table class="tbl1">
						<tr>
							<td>Employee Designation </td>
						</tr>
						<tr>
							<td><input type="text" name="designation" class="short"></td>
						</tr>
						<tr>
							<td><input type="submit" value="SAVE" name="form1"></td>
						</tr>
					</table>	
				</form>
				<br>
				<h2>View/Edit Employee Designation</h2>
				<?php
				if(isset($error_message1)) {echo "<div class='error'>".$error_message1."</div>";}
				if(isset($success_message1)) {echo "<div class='success'>".$success_message1."</div>";}
				if(isset($success_message2)) {echo "<div class='success'>".$success_message2."</div>";}
				?>
				<table class="tbl2" width="100%">
					<tr>
						<th width="10%">ID</th>
						<th width="50%">Employee Designation</th>
						<th width="15%">Action</th>
					</tr>
					
					<?php
					$i=0;
					$statement = $db->prepare("SELECT * FROM employee_designation ORDER BY designation_id ASC");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					foreach($result as $row)
					{
						$i++;
						?>
							
					<tr>
					
					<td><?php echo $i; ?></td>
					<td><?php echo $row['designation']; ?></td>
					<td>
						<a class="fancybox" href="#inline<?php echo $i; ?>"><img src="img/edit.gif"></a>
						<div id="inline<?php echo $i; ?>" style="width:400px;display: none;">
							<h3>Edit Employee Designation</h3>
							<p>
								<form action="" method="post">
									<input type="hidden" name="hdn" value="<?php echo $row['designation_id']; ?>">
									<table>
										<tr>
											<td></td>
										</tr>
										<tr>
											<td><input type="text" name="designation" value="<?php echo $row['designation']; ?>" class="medium2"></td>
										</tr>
										<tr>
											<td><input type="submit" value="UPDATE" name="form2"></td>
										</tr>
									</table>
								</form>
							</p>
						</div>
						&nbsp;|&nbsp;
						<a onclick='return confirm_delete();' href="add-designation.php?speciality_id=<?php echo $row['designation_id']; ?>"><img src="img/delete.gif"></a>
					</td>
					</tr>
					
					<?php
					}
					?>
				</table>
			</div>
		</div>
	</div>
</div>
<?php include("footer.php"); ?>			