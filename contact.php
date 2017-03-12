<?php
include("config.php");
?>


<?php
if(isset($_POST['send_message']))
{
	try {
		if(empty($_POST['name'])) {
			throw new Exception("Name can not be empty.");
		}
		if(empty($_POST['sender_email'])) {
			throw new Exception("Your Email can not be empty.");
		}
		if(!(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $_POST['sender_email']))) {
			throw new Exception('Please Enter Your valid email address');
		}
		if(empty($_POST['email'])) {
			throw new Exception("Recipient Email can not be empty.");
		}
		if(!(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $_POST['email']))) {
			throw new Exception('Please Enter Recipient Valid email address');
		}
		if(empty($_POST['message'])) {
			throw new Exception("Message can not be empty.");
		}
		$send_date = date('d-m-Y');
		$send_status=1;
		$recipent_status=1;
		
		$statement = $db->prepare("INSERT INTO message(sender_name,sender_email,recipent_email,sender_subject,sender_message,send_date,send_status,recipent_status) VALUES(?,?,?,?,?,?,?,?) ");
		$statement->execute(array($_POST['name'],$_POST['sender_email'],$_POST['email'],$_POST['subject'],$_POST['message'],$send_date,$send_status,$recipent_status));
		
		$success_message1 = "Message has been Send successfully.";
		
	}
	catch(Exception $e) {
		$error_message1 = $e->getMessage();
	}
		
}


?>



<?php include('header.php'); ?>
  	<div class="banner">
	</div>
   </div>
<div class="main">

	  <div class="section group">
				<div class="col span_2_of_contact">
				  <div class="contact-form">
				  	<h3>Contact Us</h3>
			
				<?php
				if(isset($error_message1)) {echo "<div class='error'>".$error_message1."</div>";}
				if(isset($success_message1)) {echo "<div class='success'>".$success_message1."</div>";}
				?>
					    <form name="" action="" method="POST">
					    	<div>
						    	<span><label>Name</label></span>
						    	<span><input kl_virtual_keyboard_secure_input="on" name="name" class="textbox" type="text"></span>
						    </div>
						    <div>
						    	<span><label>Your E-Mail</label></span>
						    	<span><input kl_virtual_keyboard_secure_input="on" name="sender_email" class="textbox" type="text"></span>
						    </div>
						    <div>
						    	<span><label>Recipient E-Mail</label></span>
						    	<span><input kl_virtual_keyboard_secure_input="on" name="email" class="textbox" type="text"></span>
						    </div>
							<div>
						    	<span><label>Subject</label></span>
						    	<span><input kl_virtual_keyboard_secure_input="on" name="subject" class="textbox" type="text"></span>
						    </div>
						    <div>
						    	<span><label>Message</label></span>
						    	<span><textarea name="message"> </textarea></span>
						    </div>
						   <div>
						   		<span><input value="Submit" type="submit" name="send_message"></span>
						  </div>
					    </form>
				  </div>
  				</div>
				<div class="col span_1_of_contact">
					<div class="contact_info">
    	 				<h3>Find Us Here</h3>
					    	  <div class="map">
							   	    <iframe scrolling="no" marginheight="0" marginwidth="0" src="" frameborder="0" height="175" width="100%"></iframe><br><small><a href="" style="color:#666;text-align:left;font-size:12px">View Larger Map</a></small>
							  </div>
      				</div>
      			<div class="company_address">
				     	<h3>Address</h3>
						    	<p>Savar</p>
						   		<p>Dhaka</p>
						   	
				   		<p>Mobile:(+880) 016728080808</p>
				 	 	<p>Email: <span><a href="mailto:info@cityrestaurant.com">info@cityrestaurant.com</a></span></p>
				   		<p>Follow on: <span>Facebook</span>, <span>Twitter</span></p>
				   </div>
				 </div>
				 <div class="clear"></div> 
			  </div>

		   		<div class="heading">
				  	<h3>Our Staff</h3>
				</div>
		   		<div class="about-bottom">
				
				<?php
				include "config.php";
		/* ===================== Pagination Code Starts ================== */
		$adjacents = 7;
								
		$i=0;
		$statement = $db->prepare("SELECT * FROM employee_list ORDER BY employee_id DESC");
		$statement->execute();
		$total_pages = $statement->rowCount();
	
			$targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
			$limit = 4;                                 //how many items to show per page
			$page = @$_GET['page'];
			if($page) 
				$start = ($page - 1) * $limit;          //first item to display on this page
			else
				$start = 0;
			
			$statement = $db->prepare("SELECT * FROM employee_list ORDER BY employee_id DESC LIMIT $start, $limit");
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
					
				
					$employee_name = $row['employee_name'];
					$emp_pic = $row['emp_pic'];
					$emp_designation = $row['emp_designation'];
					$emp_contact = $row['emp_mobile'];
		
		$i++;
		?>
		<div class="col_1_of_4 span_1_of_4">
					<img class="Pimg" src="photo/employee/<?php echo $row['emp_pic']; ?>" alt="" width="310" height="220"/>
						<div class="item_content">
 							<h6 class="item_title">
							<span class="item_title_part0"><?php echo $employee_name;?> </span></h6>
							<div class="item_text"><p><?php echo $emp_designation;?></p></div>
							<div class="item_text"><p>Mobile No: <?php echo $emp_contact;?></p></div>
							<span class="item_title_part0">Mail(at)cityrestaurant.com </span>
						</div>
	
		</div>						
	<?php
	}
	?>
	<div class="pagination">
		<?php echo $pagination; ?>
	</div>
				
			
				<div class="clear"></div> 	
			
			</div>
		     <div class="clear"> </div>
	</div>
	</div>
<?php include('footer.php'); ?>