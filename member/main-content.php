<?php

include("config.php");
?>
   </div>
<div class="main">
	   <div class="heading3">
		    <h3>Featured</h3>
	    </div>
		
	    <div class="section group">
				<div class="col_1_of_4 span_1_of_4">
				<?php
				include "config.php";
				
					$statement = $db->prepare("SELECT food_category.cat_id, food_category.cat_name, food_details.food_id, food_details.food_image,food_details.food_title,food_details.food_price,food_details.food_summary FROM food_details INNER JOIN food_category ON food_details.cat_id = food_category.cat_id WHERE cat_name=? ORDER BY food_id ASC Limit 1");
					$statement->execute(array('Burgar'));
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					foreach($result as $row)
					{
				?>	
					<img src="../photo/foods/<?php echo $row['food_image']; ?>" width="300" height="160">
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
			    <div class="col_1_of_4 span_1_of_4">
				<?php
				include "config.php";
				
					$statement = $db->prepare("SELECT food_category.cat_id, food_category.cat_name, food_details.food_id, food_details.food_image,food_details.food_title,food_details.food_price,food_details.food_summary FROM food_details INNER JOIN food_category ON food_details.cat_id = food_category.cat_id WHERE cat_name=? ORDER BY food_id ASC Limit 1");
					$statement->execute(array('Sandwich'));
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					foreach($result as $row)
					{
				?>	
					<img src="../photo/foods/<?php echo $row['food_image']; ?>" width="300" height="160">
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
				<div class="col_1_of_4 span_1_of_4">
				<?php
				include "config.php";
				
					$statement = $db->prepare("SELECT food_category.cat_id, food_category.cat_name, food_details.food_id, food_details.food_image,food_details.food_title,food_details.food_price,food_details.food_summary FROM food_details INNER JOIN food_category ON food_details.cat_id = food_category.cat_id WHERE cat_name=? ORDER BY food_id ASC Limit 1");
					$statement->execute(array('Coffe'));
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					foreach($result as $row)
					{
				?>	
					<img src="../photo/foods/<?php echo $row['food_image']; ?>" width="300" height="160">
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
				<div class="col_1_of_4 span_1_of_4">
				<?php
				include "config.php";
				
					$statement = $db->prepare("SELECT food_category.cat_id, food_category.cat_name, food_details.food_id, food_details.food_image,food_details.food_title,food_details.food_price,food_details.food_summary FROM food_details INNER JOIN food_category ON food_details.cat_id = food_category.cat_id WHERE cat_name=? ORDER BY food_id ASC Limit 1");
					$statement->execute(array('Lassi'));
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					foreach($result as $row)
					{
				?>	
					<img src="../photo/foods/<?php echo $row['food_image']; ?>" width="300" height="160">
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
				<div class="clear"></div> 
			</div>
			
		   <div class="content-middle">
				<div class="lsidebar span_1_of_3">
					<img src="../images/pic4.jpg" alt="">
				</div>
				<div class="cont span_2_of_3">
					<div class="test-meta"><img src="../images/quotes.png" alt=""><span class="user">City Restaurant, </span><span class="info">Customer</span></div>
					<p class="paragraph"><a href="#">Welcome to Our Restaurant........ </a></p>
			    </div>		
				<div class="clear"></div> 		
		   </div>
		  
		   <div class="bottom-grids">
				<div class="bottom-grid1">
							<h3>Category of Food</h3>
							<span>Popular Food Category</span>
							<?php
								include "config.php";
								
									$statement = $db->prepare("SELECT * FROM food_category ORDER BY cat_id DESC ");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach($result as $row)
									{
							?>
							<ul>
								<li><a href="category.php?cat_id=<?php echo $row['cat_id']; ?>"><img src="../images/marker1.png"> <?php echo $row['cat_name']; ?></a></li>
							</ul>
							<?php
									}
							?>
								<div class="clear"> </div>
								<br>
									<a href="order.php" class="button">Read More</a>
				</div>
							<div class="bottom-grid2 bottom-mid">
									<h3>Our Restaurants</h3>
									<span>Various Types of Food</span>
									<p>Show Some Popular Food items. Any one can order our food items</p>
								
								<div class="gallery">
								<?php
								include "config.php";
								
									$statement = $db->prepare("SELECT food_category.cat_id, food_category.cat_name, food_details.food_id, food_details.food_image,food_details.food_title,food_details.food_price,food_details.food_summary FROM food_details INNER JOIN food_category ON food_details.cat_id = food_category.cat_id ORDER BY food_id DESC ");
									$statement->execute(array(''));
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach($result as $row)
									{
								?>
									<div class="gallery_images">
								
										<a href="../photo/foods/<?php echo $row['food_image']; ?>" ><img src="../photo/foods/<?php echo $row['food_image']; ?>" ></a>
								
									</div>
								<?php
									}
								?>
								</div>
								<div class="clear"> </div>
								</br>
								<a href="order.php" class="button">Read More</a> 
										
									<script src="../js/jquery.js"></script>
									<script type="text/javascript" src="../js/jquery_003.js"></script>
								    <link rel="stylesheet" type="text/css" href="../css/lightbox.css" media="screen">
									<script type="text/javascript">
								    $(function() {
								        $('.gallery a').lightBox();
								    });
								    </script>
								
							</div>
							<div class="bottom-grid1 bottom-last">
									<h3>Latest INFO</h3>
									<span></span>
									<p></p>
				
									<br>
									<!-- <a href="#" class="button">Read More</a> -->
								</div>
								<div class="clear"> </div>
							</div>
							<div class="clear"> </div>
			</div>
	</div>