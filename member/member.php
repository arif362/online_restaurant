		<?php
session_start();
if(isset($_SESSION['member_id']))
{
	$member_id=$_SESSION['member_id'];	
}
else if(isset($_SESSION['mem_username']))
{
	$mem_username=$_SESSION['mem_username'];	
}
else if(isset($_SESSION['mem_mobile'])) {
	$mem_mobile = $_SESSION['mem_mobile'];
}
else if(isset($_SESSION['mem_email'])) {
	$mem_email= $_SESSION['mem_email'];
}
else if(isset($_SESSION['mem_address'])) {
	$mem_address = $_SESSION['mem_address'];
}
?>
	
	<?php
include('config.php');

if(isset($_POST['add_member'])) {
	
		$member_name = $_POST['name'];
		$mem_address = $_POST['address'];
		$mem_sex= $_POST['sex'];
		$mem_password = $_POST['password1'];
		
	try {
		if(empty ($_POST['name'])) {
			throw new Exception('Name can not be empty');
		}

		if(empty ($_POST['address'])) {
			throw new Exception('Address can not be empty');
		}	

		if(empty ($_POST['sex'])) {
			throw new Exception('Gender can not be empty');
		}
		
		if(empty ($_POST['password1'])) {
			throw new Exception('Password can not be empty');
		}

	$mem_username=$_SESSION['mem_username'];
		
		//user login password convert md5 mode
		$password = md5($mem_password);
		$add_date = date('d-m-Y');
		
		$status = '0';
		
		include('config.php');
			
		//for emptor image 
			
		$uploaded_file = $_FILES["mem_pic"]["name"];
			$file_basename = substr($uploaded_file, 0, strripos($uploaded_file, '.')); // strip extention
			$file_ext = substr($uploaded_file, strripos($uploaded_file, '.')); // strip name
			$f1 = $mem_username. $file_ext;
			
			if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
				throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
			
		move_uploaded_file($_FILES["mem_pic"]["tmp_name"],"../photo/member/" . $f1);
		
		
		//for Member insert sql	
		$statement = $db->prepare("UPDATE member_list SET member_name=?,mem_address=?,mem_sex=?,mem_password=?,mem_pic=?,mem_add_date=? WHERE member_id='$member_id'");
		$statement->execute(array($member_name,$mem_address,$mem_sex,$password,$f1,$add_date));
		
		$success_message ='Your Account is Update Successfully!';
	
	
	}
	
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
}

?>

<!DOCTYPE html>
<html class=" js rgba boxshadow csstransitions"><head>
<title>City Restaurant</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" media="all">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/css.css" rel="stylesheet" type="text/css">
<link  rel="shortcut icon" type="image/icon" href="../images/icons.png" />
<!--slider-->
<link rel="stylesheet" href="../css/flexslider.css" type="text/css" media="all">
 <script type="text/javascript" src="../js/jquery-1.9.0.min.js"></script>
 <script src="../js/highlightNav.js"></script>

  <link href="../style.css" type="text/css" rel="stylesheet" />		
  <!-- Ajax Selected Dropdown Scripts-->
		<script type="text/javascript">
		$(document).ready(function() {
			$("#cat_id").change(function() {
				$(this).after('<div id="loader"><img src="../img/loading.gif" alt="Loading Food Category" /></div>');
				$.get('get-category.php?cat_id=' + $(this).val(), function(data) {
					$("#category").html(data);
					$('#loader').slideUp(200, function() {
						$(this).remove();
					});
				});	
			});
		 
		});
		</script>
</head>

<body>

<script async="" type="text/javascript" src="../js/fancybar.js" id="_fancybar_js"></script>


<div class="header-box"></div>
<div class="wrap"> 
	<div class="total">
		<div class="header">
			<div class="header-bot">
				<div class="logo">
					<a href="index.php"><img src="../images/logo.png" alt=""></a>
				</div>
				<ul class="follow_icon">
					<li><a href="#"><img src="../images/fb1.png" alt=""></a></li>
					<li><a href="#"><img src="../images/rss.png" alt=""></a></li>
					<li><a href="#"><img src="../images/tw.png" alt=""></a></li>
					<li><a href="#"><img src="../images/g.png" alt=""></a></li>
				</ul>
			    <div class="clear"></div> 
			</div>
			<div class="search-bar">
				<form action="search-food.php" method="post">
			    <input kl_virtual_keyboard_secure_input="on" class="textbox" value=" Search Food Items" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}" type="text" name="search">
			    <input name="searchsubmit" src="images/search-icon.png" value="Go" id="searchsubmit" class="btn" type="image">
         	    </form>
				 <div class="clear"></div>
    		</div>
			<div class="clear"></div> 
		 </div>	
		<div class="menu"> 	
			<nav>
				<ul class="navigation">
					<li class="highlight"><a href="index.php">Home</a></li>
					<li><a href="about.php">About</a></li> |
					<li><a href="menu.php">Menu</a></li> |
					<li><a href="service.php">Services</a></li> |
					<li><a href="order.php">Order Foods</a></li> |
					<li><a href="#">Order List</a>
					<ul>
						<li><a href="view-pending-order.php">Pending Order</a></li>
						<li><a href="view-successful-order.php">Successful Order</a></li>
					</ul>
					</li>
					<li><a href="contact.php">Contact</a></li>  |
					<li><a href="member.php">My Profile</a></li>  |
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</nav>
		</div>	
   	<div class="banner">
	</div>
   </div>
<div class="main">
	  <div class="pricing">
				<h3>UPDATE MY PROFILE</h3>
		<p>&nbsp;</p>
		<?php
		if(isset($error_message)) {echo "<div class='error'>".$error_message."</div>";}
		if(isset($success_message)) {echo "<div class='success'>".$success_message."</div>";}
		?>
		<?php
		$statement = $db->prepare("SELECT * FROM member_list WHERE member_id='$member_id' ");
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		foreach($result as $row)
			{
				
			?>
		<form class="form_part" action="" method="post" enctype="multipart/form-data">
			<table class="tbl1">
			<tr>
				<td>Member Name</td>
				<td><input class="medium2" type="text" name="name" placeholder="Name" value="<?php echo $row['member_name'];?>"></td>
			</tr>
				
			<tr>
				<td>Address</td>
				<td><input  class="medium2" type="text" name="address" placeholder="Address" value="<?php echo $row['mem_address'];?>"></td>
			</tr>
	
			<td>Gender</td>
				<td>
					<select name="sex" class="short">
						<option value="<?php echo $row['mem_sex'];?>"> <?php echo $row['mem_sex'];?> </option>
						<option> -------- Select Gender ---------</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Enter Passowrd</td>
				<td><input  class="medium2" type="password" name="password1" placeholder="Password"></td>
			</tr>
			
			<tr>
				<td>Your Profile Picture</td>
				<td><input type="file" name="mem_pic"></td>
			</tr>
				
			<tr>
				<td><input class="short" type="submit" value="SAVE" name="add_member"></td>
			</tr>
			</table>	
			
		</form>
			<?php
			}
			?>
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
					<img class="Pimg" src="../photo/employee/<?php echo $row['emp_pic']; ?>" alt="" width="310" height="220"/>
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
				
				</div>
				
				<div class="clear"></div> 	
			
				</div>
		     <div class="clear"> </div>
	</div>
	</div>
<?php include('footer.php'); ?>