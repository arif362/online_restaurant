<?php  
if(isset($_REQUEST['cat_id'])) {

	$category = $_REQUEST['cat_id'];
}
include "config.php";
?>


<?php include('header.php'); ?>
</div>
<div class="main">
	   <div class="heading3">
		    <h3>Food Category</h3>
	    </div>
		
	    <div class="section group">
				<div class="col_1">
					<?php
						include('config.php');
						/* ===================== Pagination Code Starts ================== */
						$adjacents = 7;
				
						$i=0;
						
						$statement = $db->prepare("SELECT food_category.cat_id, food_category.cat_name, food_id, food_image,food_title,food_price,food_summary FROM food_category,food_details WHERE food_category.cat_id=food_details.cat_id and food_category.cat_id='$category'  ORDER BY food_id ASC");
						$statement->execute(array());
						$total_pages = $statement->rowCount();
										
						
						$targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
						$limit = 15;                                 //how many items to show per page
						$page = @$_GET['page'];
						if($page) 
							$start = ($page - 1) * $limit;          //first item to display on this page
						else
							$start = 0;
				
						$statement = $db->prepare("SELECT food_category.cat_id, food_category.cat_name, food_id, food_image,food_title,food_price,food_summary FROM food_category,food_details WHERE food_category.cat_id=food_details.cat_id and food_category.cat_id='$category' ORDER BY food_id ASC Limit  $start, $limit");
						$statement->execute(array());
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
							$i++;
							?>
				
					<img src="photo/foods/<?php echo $row['food_image']; ?>" width="300" height="160">
					<div class="desc">
						<div class="left-text">
							<h5>
						<a href="order.php"><?php echo $row['food_title']; ?></a></h5>
						</div>
						<span class="price"><small>BDT.</small><?php echo $row['food_price']; ?></span>
					</div>
				<?php
					}
				?>
				</div>	
		</div>
	</div>
	</div>
<?php include('footer.php'); ?>