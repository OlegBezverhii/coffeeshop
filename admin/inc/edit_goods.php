<?php if(local) die('error'); ?>
<div class="content">
<?php
	if (!isset($_GET['id']))
	{
		echo "<h2 align='center'>Редактирование товара</h2>";
		echo "<p>Чтобы отредактировать товар, нажмите на его название.</p><br>";
		$result = mysql_query("SELECT name,goods_id FROM goods");      
		$myrow = mysql_fetch_array($result);
		echo "<table border='0' align='center' cellspacing='2' cellpadding='4'>
		  <tr>
			<th>Название товара</th>
			<th>Действие</th>
		  </tr>";
		do
		{
		printf ("<tr><td><a href='index.php?page=editgoods&id=%s'>%s</a></td><td><a href='index.php?page=editgoods&id=%s&delgoods'>Удалить</a></td></tr>",$myrow["goods_id"],$myrow["name"],$myrow["goods_id"]);
		}

		while ($myrow = mysql_fetch_array($result));
		echo "</table>";
	}

else

{
	$id = $_GET['id'];
	if(isset($_GET['delgoods']))
	{
		if (isset($id))
		{
		$result = mysql_query ("DELETE FROM goods WHERE goods_id='$id'");

		if ($result == 'true') $_SESSION['edit']['res'] = "Ваш товар удалён!";
		else $_SESSION['edit']['res'] = "Ваш товар не удалился!";

		}		 
		else 

		{
		$_SESSION['edit']['res'] = "Вы запустили данный фаил без параметра id";
		}
	}
else
{
$result = mysql_query("SELECT * FROM goods WHERE goods_id=$id");      
$myrow = mysql_fetch_array($result);

print <<<HERE

<form name="editgoods" method="post">
		<table width="421" height="125">
		<tr>
			<td width="180"><label for="name">*Имя:</label></td>
			<td width="225"><input type="text" required  name="name" placeholder="Кофе" value="$myrow[name]"/></td>
		</tr>
		<tr>
			<td><label for="img">*Имя файла изображения товара</label></td>
			<td><input type="text" required  name="img" placeholder="123.jpeg" value="$myrow[img]"/></td>
		</tr>
		<tr>
			<td><label for="price">*Цена</label></td>
			<td><input type="text" required  name="price" placeholder="2000" value="$myrow[price]"/></td>
		</tr>
		<tr>
			<td><label for="inv">*Единица измерения</label></td>
			<td><input type="text" required  name="inv" placeholder="1 шт." value="$myrow[inv]"/></td>
		</tr>
		<tr>
			<td><label for="cat_id">*Родительская категория:</label></td>
			<td><select name="cat_id">
HERE;

		$res1 = mysql_query("SELECT cat_id,name FROM category",$db);
		while($cat = mysql_fetch_array($res1))
		{  
			if($myrow['cat_id'] == $cat['cat_id'])
			{echo "<option value='".$cat['cat_id']."' selected>".$cat['name']."</option>";}
			else echo "<option value='".$cat['cat_id']."'>".$cat['name']."</option>";
		}
        echo "</select></td>
		</tr>";
		echo "<tr>
			<td><label for='visible'>*Видимость</label></td>
			<td><select name='visible'>";
		if($myrow['visible']==0)
		echo "<option value='0' selected>Не видим</option>
			<option value='1'>Видим</option>";
		else
		echo "<option value='0'>Не видим</option>
			<option value='1' selected>Видим</option>";
		echo "</select></td>
		</tr>";
		echo "<tr>
			<td><label for='text'>*Описание</label></td>
			<td><textarea name='text' cols='40' rows='20'>".$myrow['text']."</textarea></td>
		</tr>
	  </table>";
	  echo"<p><input name='goods_id' type='hidden' value='".$myrow['goods_id']."'></p><p><input type='submit' name='editgoods' value='Изменить товар'></p></form>";
}
}
?>
	<?php 
		if(isset($_SESSION['edit']['res']))
		{
			echo '<div class="error">' .$_SESSION['edit']['res']. '</div>';
			unset($_SESSION['edit']['res']);
		}
	?>
</div>