<?php if(local) die('error'); ?>
		</div>
        <div id="content" class="float_r">
        	
			<?php $result = mysql_query("SELECT * FROM recept",$db);
				while($myrow = mysql_fetch_array($result))
				{
				   echo "<p>".$myrow["img"]."</p>";
				   echo "<p>".$myrow["title"]."</p>";
				   echo "<p>".$myrow["text"]."</p>";
				   echo "<div class='cleaner'></div>";
				}
			?>     	
        </div> 
        <div class="cleaner"></div>