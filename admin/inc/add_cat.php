<?php if(local) die('error'); ?>
<div class="content">
	<h2>Добавить категорию</h2>
	<form name="addcat" method="post">
			 <p>
			   <label>Введите название категории<br>
				 <input type="text" name="name" required >
				 </label>
			 </p>
			 <p>
			   <label>Выберите категорию из списка<br>
			   <select name="podcat_id" required >
				<option value="0">Самостоятельная категория</option>
				<?php
				$res1 = mysql_query("SELECT cat_id,name FROM category WHERE podcat_id =0",$db);
					while($cat = mysql_fetch_array($res1))
					{  
						echo "<option value='".$cat['cat_id']."'>".$cat['name']."</option>";
					}
				?>
				</select>
			   </label>
			 </p>
			 <p>
			   <label>Ссылка на изображение<br>
			   <input type="text" name="anons" value="kryzka.jpg">
			   </label>
			 </p>
			 <p>
			   <label>
			   <input type="submit" name="addcat" value="Добавить категорию">
			   </label>
			 </p>
	</form>
	<?php 
		if(isset($_SESSION['edit']['res']))
		{
			echo '<div class="error">' .$_SESSION['edit']['res']. '</div>';
			unset($_SESSION['edit']['res']);
		}
	?>
</div>