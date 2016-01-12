<?php if(local) die('error'); ?>
		</div>
        <div id="content" class="float_r">
        	<?php 
				if(isset($_GET['search']))
				{
					$search = teg($_GET['keyword']);
					$result_search = array();
					if(strlen($search) <4)
					{
						echo "<strong>Запрос меньше 4 символов</strong>";
					}
					else
					{
						echo "<h2>Результаты поиска</h2><br>";
						$query = mysql_query("SELECT goods_id,name,img,price,cat_id,inv FROM goods WHERE name LIKE '%".$search."%' AND visible='1'");
						
						if(mysql_num_rows($query) >0)
						{
							while($row_search = mysql_fetch_assoc($query))
							{
								$result_search[] = $row_search;
							}
							
							foreach($result_search as $product)
							{
								echo "<div class='product_box'>";
								echo "<h3><a href='?page=shop&goods_id=".$product['goods_id']."'>".$product['name']."</a></h3>";
								echo "<a href='?page=shop&goods_id=".$product['goods_id']."'><img src='images/product/".$product['img']."' width='200' height='150' alt='".$product['name']."'/></a>";
								echo "<p class='product_price'>Цена: ".$product['price']." руб. за ".$product['inv']."</p>";
								echo "<a href='?page=shop&goods_id=".$product['goods_id']."&addtocart' class='addtocart'></a>";
								echo "<a href='?page=shop&goods_id=".$product['goods_id']."' class='detail'></a>";
								echo "</div>";
							}
						}
								else
								{
									echo "<strong>Ничего не нашел :(</strong>";
								}

					}
						//echo $search;
				}
			?>
        </div> 
        <div class="cleaner"></div>