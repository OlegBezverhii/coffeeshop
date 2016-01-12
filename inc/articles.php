<?php if(local) die('error'); ?>
		</div>
        <div id="content" class="float_r">
        	<?php $result = mysql_query("SELECT * FROM articles",$db);
				
				if(isset($_GET['art_id'])) {$art_id = $_GET['art_id'];}
				
				if(empty($art_id))
				{
					echo "<h3><p>Здесь вы можете прочитать интересные статьи о кофе.</p></h3>";
					while($myrow = mysql_fetch_array($result))
					{
					printf("<table align='center' class='news'>
						 <tr>
						 <td class='news_title'>
						 <p class='news_name'><a href='index.php?page=articles&art_id=%s'>%s</a></p>
						 </td>
						 </tr>
						 
						 <tr>
						 <td>%s</td>
						 </tr>  
							</table>", $myrow["id"], $myrow["title"],$myrow["description"]);
					}
				}
				else
				{
				 /*echo "Proba";*/
				 $result3 = mysql_query("SELECT * FROM articles WHERE id='$art_id'",$db);
				 while($my = mysql_fetch_array($result3))
				 {
				   echo "<p class='view_title'>".$my["title"]."</p><br />";
				   echo "<p class='view_date'>".$my["text"]."</p>";
				 }
				}
			?>     	
        </div> 
        <div class="cleaner"></div>
		<p></p>