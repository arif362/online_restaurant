	<?php
session_start();
if(isset($_SESSION['member_id']))
{
	$member_id=$_SESSION['member_id'];	
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

require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT * FROM food_details WHERE food_id='" . $_GET["food_id"] . "'");
			$itemArray = array($productByCode[0]["food_id"]=>array('food_title'=>$productByCode[0]["food_title"], 'food_id'=>$productByCode[0]["food_id"], 'quantity'=>$_POST["quantity"], 'food_price'=>$productByCode[0]["food_price"]));
			
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[0]["food_id"],$_SESSION["cart_item"])) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["food_id"] == $k)
								$_SESSION["cart_item"][$k]["quantity"] = $_POST["quantity"];
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
			header("location:order2.php");
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["food_id"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
			header("location:order2.php");
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
		header("location:order2.php");
	break;	
}
}
?>

<?php
include('config.php');


if(isset($_POST['add_food']))
{
	$mobile= $_SESSION['mem_mobile'];
	$to= $_SESSION['mem_email'];
	
	try {

		if(empty($_POST['payment_types'])) {
			throw new Exception("Payment Types can not be empty.");
				
		}
			if(empty($_POST['c_account'])) {
			throw new Exception("Account Number can not be empty.");
				
		}
		
		$member_id=$_SESSION['member_id'];	
		$mem_mobile=$_SESSION['mem_mobile'];
		$mem_email=$_SESSION['mem_email'];	
		$mem_address=$_SESSION['mem_address'];			
		
		$food_title=implode(', ',$_POST['food_title']);	
		$food_id=implode(', ',$_POST['food_id']);	
		$quantity=implode(', ',$_POST['quantity']);	
		$food_price=implode(', ',$_POST['food_price']);
		
		$customer='Member';
		$add_date = date('d-m-Y');
		$time_zone = date_default_timezone_set("Asia/Dhaka");
		$add_time = date("h:i:s A", time());
		$month = date('M');
		$year = date('Y');
		$password=md5($_POST['c_mobile']);

		$active=0;
		$confirm_code= rand();
	
		$statement = $db->prepare("INSERT INTO order_list(member_id,c_mobile,c_email,c_address,c_account,user_types,food_title,food_id,quantity,total_quantity,food_price,total,payment_types,account,send_date,send_time,month,year,status,confirm_code) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$statement->execute(array($member_id,$mem_mobile,$mem_email,$mem_address,$_POST['c_account'],$customer,$food_title,$food_id,$quantity,$_POST['t_quantity'],$food_price,$_POST['total'],$_POST['payment_types'],$_POST['payment'],$add_date,$add_time,$month,$year,$active,$confirm_code));
		
               $subject="Order Confirmation Message";

		$message=
		"
		Dear
		Member, Please Confirm Your Food Order  
		Click the link below to confirm your order
		http://cityrestaurant.cuccfree.com/order-confirmation.php?email=$to&code=$confirm_code

                Regrads,
                City Resturant
                
		";
                
		$headers ="From: City Restaurant <18266026@hostingaccount.com>\r\n";
		$headers .="Reply To: reply-to <18266026@hostingaccount.com>\r\n";
		$headers .="Content-type:text/html\r\n";
		
		mail($to,$subject,$message,$headers);
		
		header("location:success-message.php");

		$success_message = "Food has been Send successfully.";
		
	
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
 
  <script type="text/javascript" language="javascript" src="../js/order-validation.js"></script>
  
  <link href="../style.css" type="text/css" rel="stylesheet" />		
  <!-- Ajax Selected Dropdown Scripts-->
		<script type="text/javascript">
		$(document).ready(function() {
			$("#payment_types").change(function() {
				$(this).after('<div id="loader"><img src="img/loading.gif" alt="Loading Payment Number" /></div>');
				$.get('get-payment.php?payment_types=' + $(this).val(), function(data) {
					$("#payment").html(data);
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
					<li><a href="member.php">MY Profile</a></li>  |
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</nav>
		</div>	
   	<div class="banner">
	</div>
   </div>
<div class="main">
	  <div class="pricing">
				<?php
					if(isset($error_message)) {echo "<div class='error'>".$error_message."</div>";}
					if(isset($success_message)) {echo "<div class='success'>".$success_message."</div>";}
				?>			
							
				<div id="shopping-cart">
<div class="txt-heading">Add Foods Cart <a id="btnEmpty" href="order2.php?action=empty">Empty Cart</a></div>
<?php
if(isset($_SESSION["cart_item"])){
	$total_quantity = 0;
    $item_total = 0;
?>
<form action=" " name="cityrestaurant" id="order_form" method="post" enctype="multipart/form-data">
<table cellpadding="10" cellspacing="1" class="tbl1">
<tbody>
<tr>
<th><strong>Name</strong></th>
<th><strong>Food Id</strong></th>
<th><strong>Quantity</strong></th>
<th><strong>Price</strong></th>
<th><strong>Total Price</strong></th>
<th><strong>Action</strong></th>
</tr>	
<?php		
    foreach ($_SESSION["cart_item"] as $item){
		$fq= $item["quantity"]*$item["food_price"]
		?>

				<tr>
				<td><strong><input type="hidden" name="food_title[]" value="<?php echo $item["food_title"]; ?>"><?php echo $item["food_title"]; ?></strong></td>
				<td><input type="hidden" name="food_id[]" value="<?php echo $item["food_id"]; ?>"><?php echo $item["food_id"]; ?></td>
				<td><input type="hidden" name="quantity[]" value="<?php echo $item["quantity"]; ?>"><?php echo $item["quantity"]; ?></td>
				<td ><input type="hidden" name="food_price[]" value="<?php echo $item["food_price"]; ?>"><?php echo 'BDT. '.$item["food_price"]; ?></td>
				<td align=right><input type="hidden" name="fq" value="<?php echo $fq; ?>"><?php  echo 'BDT. '.$fq; ?></td>
				<td><a href="order.php?action=remove&food_id=<?php echo $item["food_id"]; ?>" class="btnRemoveAction">Remove Item</a></td>
				</tr>
				<?php
       $total_quantity += $item["quantity"];
       $item_total += ($item["food_price"]*$item["quantity"]);
		}
		?>
<tr>
<td colspan="6" align=right><input type="hidden" name="t_quantity" value="<?php echo $total_quantity; ?>"><strong>Total Quantity:</strong> <?php echo $total_quantity; ?></td>
</tr>
<tr>
<td colspan="6" align=right><input type="hidden" name="total" value="<?php echo $item_total; ?>"><strong>Total:</strong> <?php echo 'BDT. '.$item_total; ?></td>
</tr>
	
	<tr><td align=left>Payment Method: <select name="payment_types" id="payment_types">
		<option value="0">--- Select Payment Method ---</option>
			<?php
					$statement = $db->prepare("SELECT * FROM payment ORDER BY payment_id ASC");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
						foreach($result as $row)
							{
							$payment_id=$row['payment_id'];
							$payment_types=$row['payment_types'];
							?>
								<option value="<?php echo $row['payment_types']; ?>"><?php echo $row['payment_types']; ?></option>	
									
							<?php
								}
							?>
	</select>
	</td><td align=left colspan="6"><span class="error_form" id="payment_error"></span></td></tr>
	<tr><td colspan="6" align=left><div id="payment"></div></td></tr>
	<tr><td align=left>Your Account No: <input class="short" type="text" name="c_account" maxlength="16"  placeholder="Your Account No" id="c_account"></td><td align=left colspan="6"><span class="error_form" id="account_error"></span></td></tr>
					<tr>
						<td colspan="6" align=left><input type="submit" value="Order Food" name="add_food"></td>
					</tr>
</tbody>
	
</table>
</form>		
  <?php
}
?>
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