<?php if(local) die('error');?>
<div class="content">
	<h2>Добавление товара</h2>
	<form name="addgoods" method="post">
		<table width="421" height="125">
		<tr>
			<td width="180"><label for="name">*Имя:</label></td>
			<td width="225"><input type="text" required  name="name" placeholder="Кофе" /></td>
		</tr>
		<tr>
			<td><label for="img">*Имя файла изображения</label></td>
			<td><input type="text" required  name="img" placeholder="123.jpeg" /></td>
		</tr>
		<tr>
			<td><label for="price">*Цена</label></td>
			<td><input type="text" required  name="price" placeholder="2000" /></td>
		</tr>
		<tr>
			<td><label for="inv">*Единица измерения</label></td>
			<td><input type="text" required  name="inv" placeholder="1 шт." /></td>
		</tr>
		<tr>
			<td><label for="visible">*Видимость</label></td>
			<td><select name="visible">
        	<option value="1">Видим</option>
			<option value="0">Не видим</option>
			</select></td>
		</tr>
		<tr>
			<td><label for="cat_id">*Родительская категория:</label></td>
			<td><select name="cat_id">
			<?php 
			$res1 = mysql_query("SELECT cat_id,name FROM category",$db);
			while($cat = mysql_fetch_array($res1))
			{  echo "<option value='".$cat['cat_id']."'>".$cat['name']."</option>";}
			?>
        </select></td>
		</tr>
		<tr>
			<td><label for="text">*Описание</label></td>
			<td><textarea name="text" id="text" cols="40" rows="20"></textarea></td>
		</tr>
	  </table> 
	  <p>
		<input type="submit" name="addgoods" value="Добавить товар">
	  </p>
	</form>
	</br>
	<?php 	
		if(isset($_SESSION['edit']['res']))
		{
			echo '<div class="error">' .$_SESSION['edit']['res']. '</div>';
			unset($_SESSION['edit']['res']);
		} 
	?>
</div>