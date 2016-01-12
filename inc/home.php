<?php if(local) die('error'); ?>
        </div>
        <div id="content" class="float_r">
        	<!--<div id="slider-wrapper">
                <div id="slider" class="nivoSlider">
                    <img src="images/slider/02.jpg" alt="" />
                    <a href="#"><img src="images/slider/01.jpg" alt="" title="This is an example of a caption" /></a>
                    <img src="images/slider/03.jpg" alt="" />
                    <img src="images/slider/04.jpg" alt="" title="#htmlcaption" />
                </div>
                <div id="htmlcaption" class="nivo-html-caption">
                    <strong>This</strong> is an example of a <em>HTML</em> caption with <a href="#">a link</a>.
                </div>
            </div>
            <script type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
            <script type="text/javascript" src="js/jquery.nivo.slider.pack.js"></script>
            <script type="text/javascript">
            $(window).load(function() {
                $('#slider').nivoSlider();
            });
            </script>-->
        	<?php $result = mysql_query("SELECT * FROM news ORDER BY date DESC",$db);
				if(isset($_GET['news_id'])) {$news_id = $_GET['news_id'];}
				
				if(empty($news_id))
				{
					echo "<h3><p align='center'>Добро пожаловать на наш сайт</p></h3><br/>";
					//echo "<p align='left'>Новости сайта</p><br/>";
					while($myrow = mysql_fetch_array($result))
					{
					printf("<table align='center' class='news'>
						 <tr>
						 <td class='news_title'>
						 <p class='news_name'><a href='index.php?news_id=%s'>%s</a></p>
						 <p class='news_adds'>Дата добавления: %s</p>
						 </td>
						 </tr>
						 
						 <tr>
						 <td>%s</td>
						 </tr>  
							</table>", $myrow["news_id"], $myrow["title"], $myrow["date"],$myrow["anons"]);
					}
					echo "<div class='cleaner'></div>";
				}
				else
				{
				 $result2 = mysql_query("SELECT * FROM news WHERE news_id='$news_id'",$db);
				 while($myrow = mysql_fetch_array($result2))
				 {
				   echo "<p class='view_title'>".$myrow["title"]."</p>";
				   echo "<p class='view_date'>Новость от ".$myrow["date"]."</p>";
				   echo "<p class='view_date'>".$myrow["text"]."</p>";
				 }
				}
			?>
		<p></p>
		</div> 
        <div class="cleaner"></div>