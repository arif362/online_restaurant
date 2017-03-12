<?php include('header.php'); ?>
   	<div class="banner">
	</div>
   </div>
<div class="main">

	  <div class="section group">
					 <div class="cont2 span_2_of_services services_desc">
				       <h2>OUr Services</h2>
				           <p> 
						   We are more than just your average, local Bangladeshi restaurant; there's a whole community at work behind our award-winning doors...

City Restaurant

Stylish yet homely

Seats 120

Mix of booths and open-seating

Family friendly

</p>


				      </div>
				      <div class="lsidebar2 sidebar2 offers_list">
				         <h2>What We Offer</h2>
				     		<ul>
		  						<li>Spring Offer </li>
		  						<li>Summer Offer </li>
		  						<li>Winter Offer </li>
		  						
		  					</ul>
		  					
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
				
				</div>
				<div class="clear"></div> 	
			
		     <div class="clear"> </div>
	</div>
	</div>
<?php include('footer.php'); ?>