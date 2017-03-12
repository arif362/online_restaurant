<?php
include('config.php');

if(isset($_POST['add_member'])) {
	
		$member_name = $_POST['name'];
		$mem_username = $_POST['username'];
		$mem_email = $_POST['email'];
		$mem_address = $_POST['address'];
		$mem_mobile = $_POST['mobile'];
		$mem_birthday = $_POST['birth_day']."-".$_POST['birth_month']."-".$_POST['birth_year'];
		$mem_sex= $_POST['sex'];
		$mem_password = $_POST['password1'];
		
                 $to=$_POST['email'];
	
		 $emailCHecker = mysql_real_escape_string($mem_email);
		 $emailCHecker = str_replace("`", "", $emailCHecker);
		 
	   // Database duplicate username check setup for use below in the error handling if else conditionals
		 $statement = $db->prepare("SELECT mem_username FROM member_list WHERE mem_username=?");
		 $statement->execute(array($mem_username));
		 $uname_check = $statement->rowCount();
		 
		 // Database duplicate e-mail check setup for use below in the error handling if else conditionals
		 $statement = $db->prepare("SELECT mem_email FROM member_list WHERE mem_email=?");
		 $statement->execute(array($emailCHecker));
		 $email_check = $statement->rowCount();
		 
		 // Database duplicate mobile check setup for use below in the error handling if else conditionals
		 $statement = $db->prepare("SELECT mem_mobile FROM member_list WHERE mem_mobile=?");
		 $statement->execute(array($mem_mobile));
		 $mobile_check = $statement->rowCount();
	 
	try {
		if(empty ($_POST['name'])) {
			throw new Exception('Name can not be empty');
		}
		if(empty ($_POST['username'])) {
			throw new Exception('User Name can not be empty');
		}
		
		//duplicate username check 
		if ($uname_check > 0)  {
			throw new Exception('Your User Name is already in use inside of our system. Please try another.');
		}
		
		if(!(preg_match("/^[A-Za-z][A-Za-z0-9]{3,21}$/", $mem_username))) {
			throw new Exception('Please Enter The Valid User Name');
		}
		
		if(empty ($_POST['email'])) {
			throw new Exception('Email can not be empty');
		}
		
		if(!(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $mem_email))) {
			throw new Exception('Please Enter Valid email address');
		}
		//duplicate email check 
		if ($email_check > 0){
			throw new Exception('Your Email address is already in use inside of our system. Please use another');
		}
		if(empty ($_POST['address'])) {
			throw new Exception('Address can not be empty');
		}	
		if(empty ($_POST['mobile'])) {
			throw new Exception('Mobile Number can not be empty');
		}	
		//duplicate mobile check 
		if ($mobile_check > 0)  {
			throw new Exception('Your Mobile is already in use inside of our system. Please try another.');
		}
	
		if(empty ($_POST['birth_month'])) {
			throw new Exception('Birth Month can not be empty');
		}
		
		if(empty ($_POST['birth_day'])) {
			throw new Exception('Birth Day can not be empty');
		}
		
		if(empty ($_POST['birth_year'])) {
			throw new Exception('Birth Year can not be empty');
		}
		if(empty ($_POST['sex'])) {
			throw new Exception('Gender can not be empty');
		}
		
		if(empty ($_POST['password1'])) {
			throw new Exception('Password can not be empty');
		}
		if(empty ($_POST['password2'])) {
			throw new Exception('Password can not be empty');
		}
		if($_POST['password1']!= $_POST['password2'] ) {
			throw new Exception('Password does not match');
		}
	
		
		//user login password convert md5 mode
		$password = md5($mem_password);
		$add_date = date('d-m-Y');
		
		$status = '0';
		
		include('config.php');
			
		//for member image 
			
		$uploaded_file = $_FILES["mem_pic"]["name"];
			$file_basename = substr($uploaded_file, 0, strripos($uploaded_file, '.')); // strip extention
			$file_ext = substr($uploaded_file, strripos($uploaded_file, '.')); // strip name
			$f1 = $mem_username. $file_ext;
			
			if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
				throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
			
		move_uploaded_file($_FILES["mem_pic"]["tmp_name"],"photo/member/" . $f1);
		
		$confirmation_code= rand();

		//for Member insert sql	
		$statement = $db->prepare("INSERT INTO member_list ( member_name,mem_username,mem_email,mem_address,mem_mobile,mem_birthday,mem_sex,mem_password,mem_pic,mem_add_date,mem_status,code) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
		$statement->execute(array($member_name,$mem_username,$mem_email,$mem_address,$mem_mobile,$mem_birthday,$mem_sex,$password,$f1,$add_date,$status,$confirmation_code));
		
                 $subject="Registration Confirmation Message";

		$message=
		"
		Dear
		Member, Please Active Your Membership Then You login Your Account
		Click the link below to confirm your member registration
		http://cityrestaurant.cuccfree.com/member-confirmation.php?username=$mem_username&email=$mem_email&code=$confirmation_code

                Regrads,
                City Resturant
                
		";
                
		$headers ="From: City Restaurant <cityrestaurant.bd@gmail.com>\r\n";
                $headers .="Reply To: reply-to <18266026@hostingaccount.com>\r\n";
		$headers .="Content-type:text/html\r\n";
		
		mail($to,$subject,$message,$headers);

		header('Location:registration-complete-message.php');
		
		$success_message ='Your Account is Create Successfully! We Send a Confirmation Email Then You Can Login Our Restaurant.';
	
	
	}
	
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
}

?>
<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
unset($_SESSION["cart_item"]);
?>

<!DOCTYPE html>
<html class=" js rgba boxshadow csstransitions"><head>
<title>City Restaurant</title>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/css.css" rel="stylesheet" type="text/css">
<link  rel="shortcut icon" type="image/icon" href="images/icons.png" />
<!--slider-->
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="all">
 <script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
 <script src="js/highlightNav.js"></script>

  <link href="style.css" type="text/css" rel="stylesheet" />		
  
  <script type="text/javascript" language="javascript" src="js/validation.js"></script>
</head>

<body>

<script async="" type="text/javascript" src="js/fancybar.js" id="_fancybar_js"></script>


<div class="header-box"></div>
<div class="wrap"> 
	<div class="total">
		<div class="header">
			<div class="header-bot">
				<div class="logo">
					<a href="index.php"><img src="images/logo.png" alt=""></a>
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
					<li><a href="contact.php">Contact</a></li>  |
					<li><a href="member.php">Registration</a></li>  |
					<li><a href="login.php">Login</a></li>
				</ul>
			</nav>
		</div>	
   	<div class="banner">
	</div>
   </div>
<div class="main">
	  <div class="pricing">
				<h3>CREATE YOUR ACCOUNT</h3>
		<p>&nbsp;</p>
		<?php
		if(isset($error_message)) {echo "<div class='error'>".$error_message."</div>";}
		if(isset($success_message)) {echo "<div class='success'>".$success_message."</div>";}
		?>
		
		<form class="form_part" id="registration_form" action=" " method="post" enctype="multipart/form-data">
			<table class="tbl1">
			<tr>
				<td>Member Name</td>
				<td><input class="medium2" type="text" name="name" placeholder="Like: Mst. Samin" id="form_name"></td><td><span class="error_form" id="name_error_message"></span></td>
			</tr>
				
			
			<tr>
				<td>User Name</td>
				<td><input class="medium2" type="text" name="username" maxlength="20" placeholder="Username" id="form_username"></td><td><span class="error_form" id="username_error_message"></span></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input  class="medium2" type="text" name="email" placeholder="Email" id="form_email"></td><td><span class="error_form" id="email_error_message"></span></td>
			</tr>
			<tr>
				<td>Address</td>
				<td><input  class="medium2" type="text" name="address" placeholder="Address" id="form_address"></td><td><span class="error_form" id="address_error_message"></span></td>
			</tr>
			<tr>
				<td>Mobile No</td>
				<td><input  class="medium2" type="text" name="mobile" maxlength="11" placeholder="Mobile No" id="form_mobile"></td><td><span class="error_form" id="mobile_error_message"></span></td>
			</tr>
			
			<tr>
			<td>Select Birthday</td>
					<td>	
							<select name="birth_day" id="form_day">
							<option value="0">&nbsp; Day &nbsp; </option>
							<option value="01">1</option>
							<option value="02">2</option>
							<option value="03">3</option>
							<option value="04">4</option>
							<option value="05">5</option>
							<option value="06">6</option>
							<option value="07">7</option>
							<option value="08">8</option>
							<option value="09">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21">21</option>
							<option value="22">22</option>
							<option value="23">23</option>
							<option value="24">24</option>
							<option value="25">25</option>
							<option value="26">26</option>
							<option value="27">27</option>
							<option value="28">28</option>
							<option value="29">29</option>
							<option value="30">30</option>
							<option value="31">31</option>
							</select> 
							<select name="birth_month" id="form_month">
							<option value="0"> &nbsp; Month &nbsp; </option>
							<option value="01">January</option>
							<option value="02">February</option>
							<option value="03">March</option>
							<option value="04">April</option>
							<option value="05">May</option>
							<option value="06">June</option>
							<option value="07">July</option>
							<option value="08">August</option>
							<option value="09">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
							</select> 
				
							<select name="birth_year" id="form_year">
							<option value="0"> &nbsp; Year &nbsp; </option>
							<option value="2010">2010</option>
							<option value="2009">2009</option>
							<option value="2008">2008</option>
							<option value="2007">2007</option>
							<option value="2006">2006</option>
							<option value="2005">2005</option>
							<option value="2004">2004</option>
							<option value="2003">2003</option>
							<option value="2002">2002</option>
							<option value="2001">2001</option>
							<option value="2000">2000</option>
							<option value="1999">1999</option>
							<option value="1998">1998</option>
							<option value="1997">1997</option>
							<option value="1996">1996</option>
							<option value="1995">1995</option>
							<option value="1994">1994</option>
							<option value="1993">1993</option>
							<option value="1992">1992</option>
							<option value="1991">1991</option>
							<option value="1990">1990</option>
							<option value="1989">1989</option>
							<option value="1988">1988</option>
							<option value="1987">1987</option>
							<option value="1986">1986</option>
							<option value="1985">1985</option>
							<option value="1984">1984</option>
							<option value="1983">1983</option>
							<option value="1982">1982</option>
							<option value="1981">1981</option>
							<option value="1980">1980</option>
							<option value="1979">1979</option>
							<option value="1978">1978</option>
							<option value="1977">1977</option>
							<option value="1976">1976</option>
							<option value="1975">1975</option>
							<option value="1974">1974</option>
							<option value="1973">1973</option>
							<option value="1972">1972</option>
							<option value="1971">1971</option>
							<option value="1970">1970</option>
							<option value="1969">1969</option>
							<option value="1968">1968</option>
							<option value="1967">1967</option>
							<option value="1966">1966</option>
							<option value="1965">1965</option>
							<option value="1964">1964</option>
							<option value="1963">1963</option>
							<option value="1962">1962</option>
							<option value="1961">1961</option>
							<option value="1960">1960</option>
							<option value="1959">1959</option>
							<option value="1958">1958</option>
							<option value="1957">1957</option>
							<option value="1956">1956</option>
							<option value="1955">1955</option>
							<option value="1954">1954</option>
							<option value="1953">1953</option>
							<option value="1952">1952</option>
							<option value="1951">1951</option>
							<option value="1950">1950</option>
							<option value="1949">1949</option>
							<option value="1948">1948</option>
							<option value="1947">1947</option>
							<option value="1946">1946</option>
							<option value="1945">1945</option>
							<option value="1944">1944</option>
							<option value="1943">1943</option>
							<option value="1942">1942</option>
							<option value="1941">1941</option>
							<option value="1940">1940</option>
							<option value="1939">1939</option>
							<option value="1938">1938</option>
							<option value="1937">1937</option>
							<option value="1936">1936</option>
							<option value="1935">1935</option>
							<option value="1934">1934</option>
							<option value="1933">1933</option>
							<option value="1932">1932</option>
							<option value="1931">1931</option>
							<option value="1930">1930</option>
							<option value="1929">1929</option>
							<option value="1928">1928</option>
							<option value="1927">1927</option>
							<option value="1926">1926</option>
							<option value="1925">1925</option>
							<option value="1924">1924</option>
							<option value="1923">1923</option>
							<option value="1922">1922</option>
							<option value="1921">1921</option>
							<option value="1920">1920</option>
							<option value="1919">1919</option>
							<option value="1918">1918</option>
							<option value="1917">1917</option>
							<option value="1916">1916</option>
							<option value="1915">1915</option>
							<option value="1914">1914</option>
							<option value="1913">1913</option>
							<option value="1912">1912</option>
							<option value="1911">1911</option>
							<option value="1910">1910</option>
							<option value="1909">1909</option>
							<option value="1908">1908</option>
							<option value="1907">1907</option>
							<option value="1906">1906</option>
							<option value="1905">1905</option>
							<option value="1904">1904</option>
							<option value="1903">1903</option>
							<option value="1902">1902</option>
							<option value="1901">1901</option>
							<option value="1900">1900</option>
							</select> 
					</td><td><span class="error_form" id="day_error_message"></span> <span class="error_form" id="month_error_message"></span> <span class="error_form" id="year_error_message"></span></td>
			</tr>
			<tr>
			<td>Gender</td>
				<td>
					<select name="sex" class="short" id="form_gender">
						<option value="0"> -------- Select Gender ---------</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
				</td><td><span class="error_form" id="gender_error_message"></span></td>
			</tr>
			<tr>
				<td>Enter Passowrd</td>
				<td><input  class="medium2" type="password" name="password1" placeholder="Password" id="form_password"></td><td><span class="error_form" id="password_error_message"></span></td>
			</tr>
			<tr>
				<td>Re Enter Password</td>
				<td><input  class="medium2" type="password" name="password2" placeholder="Confirm Password" id="form_retype_password"></td><td><span class="error_form" id="retype_password_error_message"></span></td>
			</tr>
			<tr>
				<td>Your Profile Picture</td>
				<td><input type="file" name="mem_pic" id="form_pic"></td><td><span class="error_form" id="pic_error_message"></span></td>
			</tr>
				
			<tr>
				<td><input class="short" type="submit" value="SAVE" name="add_member"></td>
			</tr>
			</table>	
		</form>

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
				
				</div>
				
				<div class="clear"></div> 	
			
				</div>
		     <div class="clear"> </div>
	</div>
	</div>
<?php include('footer.php'); ?>