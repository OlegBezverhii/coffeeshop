<?php if(local) die('error'); ?>
			<div class="sidebar_box"><span class="bottom"></span>
			<h3>Корзина</h3>
				<div class="content"> 
				<?php 
				if($_SESSION['total_quantity'])
				{ 
					echo "Товаров в корзине: <br><strong>";
					echo $_SESSION['total_quantity'];
					echo "</strong> на сумму <strong>".$_SESSION['total_sum']." руб.</strong><p></p>";
					echo "<p><a href='http://shop.com/index.php?page=oplata'>Сделать заказ</a></p>";
					echo "<a href='http://shop.com/index.php?page=shop&clearcart'>Очистить корзину</a>";
				}
				else
				{
					echo "Корзина пуста";
					//print_r($_SESSION);
				}
				?>
				</div> 
			</div>
			<div class="sidebar_box"><span class="bottom"></span>
            	<h3>Меню</h3>   
                <div class="content1"> 
                	<ul class="sidebar_list" style="padding-bottom: 0px;">
                    	<!--<li class="first"><a href="#">Sed eget purus</a></li>-->
			<?php
			$res1 = mysql_query("SELECT * FROM category WHERE podcat_id=0",$db);
			$tul=mysql_num_rows($res1); //количество извелеченных записей
			//echo $tul;
			$cu = 0; //счетчик
			while($cat = mysql_fetch_array($res1))
			{
				echo "<li><a href='?page=shop&category=".$cat['cat_id']."'>".$cat['name']."</a>";
				$cu++;
				//echo $cu;
				$res2 = mysql_query("SELECT * FROM category WHERE podcat_id=".$cat['cat_id'],$db);
				echo "<ul>";
				while($podcat = mysql_fetch_array($res2))
				{
				echo "<li><a href='?page=shop&category=".$podcat['cat_id']."'>".$podcat['name']."</a></li>";
				}
				echo "</ul></li>";
			}
			//echo $cu;
			?>
			        </ul>
                </div>
            </div>
</div>

        <div id="content" class="float_r">
        	<?php
				if(isset($_GET['category'])) {$cat_id = $_GET['category'];}
				if(isset($_GET['goods_id'])) {$tovar = $_GET['goods_id'];}

				if(empty($cat_id))
				{
					if($tovar !=0)
					{
						$query = mysql_query("SELECT * FROM goods WHERE goods_id=".$tovar." AND visible='1'");
						$row = mysql_num_rows($query);
						$product = mysql_fetch_array($query);
						
						$query2 = mysql_query("SELECT name FROM category WHERE cat_id=".$product['cat_id']."",$db);
						$cat2 = mysql_fetch_array($query2);
						if ($row != 0)
						{
							echo "<h1>Информация о продукте</h1><div class='content_half float_l'>";
							echo "<a rel='lightbox[portfolio]' href='images/product/".$product['img']."'><img src='images/product/".$product['img']."' width='300' height='200' alt='image'/></a></div>";
							echo "<div class='content_half float_r'><table>";
							echo "<tr><td width='160'>Цена:</td><td>".$product['price']." руб.</td></tr>";
							echo "<tr><td>Цена за:</td><td>".$product['inv']."</td></tr>";
							echo "<tr><td>Имя:</td><td>".$product['name']."</td></tr>";
							echo "<tr><td>Категория:</td><td>".$cat2['name']."</td></tr>";
							echo "</table><div class='cleaner h20'></div>";
							echo "<a href='?page=shop&goods_id=".$product['goods_id']."&addtocart' class='addtocart'></a></div>";
							echo "<div class='cleaner h30'></div>";
							echo "<h3>Описание товара</h3>";
							echo "<p>".$product['text']."</p><div class='cleaner h50'></div>";
						}
						else
						{echo "Такого товара нет";}
					}
					else
					{	
						echo "<h1>Выберите категорию</h1>";
						$res1 = mysql_query("SELECT * FROM category WHERE podcat_id=0",$db);
						
						while($cat = mysql_fetch_array($res1))
						{
							echo "<div class='product_box'>";
							echo "<h3><a href='?page=shop&category=".$cat['cat_id']."'>".$cat['name']."</a></h3>";
							echo "<a href='?page=shop&category=".$cat['cat_id']."'><img src='images/default/".$cat['img']."' width='200' height='150'  alt='".$cat['name']."'/></a>";
							echo "</div>";
						}
						echo "<div class='cleaner'></div>";
					}
				}
				else	
				{	
					
					if(isset($_GET['pages'])){
						$pages = (int)$_GET['pages'];
						if($pages < 1) $pages = 1;
					}else{
						$pages = 1;
					}

					$count_rows = count_rows($cat_id); // общее кол-во товаров
					$pages_count = ceil($count_rows / $perpage); // кол-во страниц
					if(!$pages_count) $pages_count = 1; // минимум 1 страница
					if($pages > $pages_count) $pages = $pages_count; // если запрошенная страница больше максимума
					$start_pos = ($pages - 1) * $perpage;
				
					
					$query = mysql_query("SELECT * FROM goods WHERE cat_id=".$cat_id." AND visible='1' UNION (SELECT * FROM goods WHERE cat_id IN (SELECT cat_id FROM category WHERE podcat_id=".$cat_id.") AND visible='1') LIMIT ".$start_pos.", ".$perpage."",$db);
					$query2 = mysql_query("SELECT * FROM category WHERE cat_id=".$cat_id."",$db);
					$cat2 = mysql_fetch_array($query2);
					echo "<h2>".$cat2['name']."</h2>";
					$row = mysql_num_rows($query);
					if ($row != 0)
					{
						while ($product = mysql_fetch_array($query))
						{
							echo "<div class='product_box'>";
							echo "<h3><a href='?page=shop&goods_id=".$product['goods_id']."'>".$product['name']."</a></h3>";
							echo "<a href='?page=shop&goods_id=".$product['goods_id']."'><img src='images/product/".$product['img']."' width='200' height='150' alt='".$product['name']."'/></a>";
							echo "<p class='product_price'>Цена: ".$product['price']." руб. за ".$product['inv']."</p>";
							echo "<a href='?page=shop&goods_id=".$product['goods_id']."&addtocart' class='addtocart'></a>";
							echo "<a href='?page=shop&goods_id=".$product['goods_id']."' class='detail'></a>";
							echo "</div>";
						}
						echo "<div class='cleaner'></div>";
						pagination($pages, $pages_count);
					}
					else
					{
						echo "<strong>Товаров в данной категории нет</strong>";
					}

				}
			?>
  	
        </div> 
        <div class="cleaner"></div>