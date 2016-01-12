<?php if(local) die('error'); ?>
<div class="content">
<?php
	if (!isset($_GET['id']))
	{
	echo "<h4 align='center'>Редактирование категорий</h4>
	<p>Удаление категории влечет за собой удаление товаров из данной категории. Будьте осторожны.</p>
	<table border='1' align='center' cellspacing='0' cellpadding='5'>
		  <tr>
			<th>Название категории</th>
			<th>Действие</th>
		  </tr>";
	$res1 = mysql_query("SELECT * FROM category WHERE podcat_id=0",$db);
	while($cat = mysql_fetch_array($res1))
	{
		echo "<tr><td bgcolor='aqua'><strong>".$cat['name']."</strong></td><td><a href='index.php?page=editcat&id=".$cat['cat_id']."'>изменить</a>&nbsp; | &nbsp;<a href='index.php?page=editcat&id=".$cat['cat_id']."&delcat'>удалить</a></td>";

		$res2 = mysql_query("SELECT * FROM category WHERE podcat_id=".$cat['cat_id'],$db);
			while($podcat = mysql_fetch_array($res2))
			{
			echo "<tr><td>".$podcat['name']."</td><td><a href='index.php?page=editcat&id=".$podcat['cat_id']."'>изменить</a>&nbsp; | &nbsp;<a href='index.php?page=editcat&id=".$podcat['cat_id']."&delcat'>удалить</a></td>";
			}	
	}
	echo "</table>";
	}
else

{
	$id = $_GET['id'];
	if(isset($_GET['delcat']))
	{
		//echo "dalyau";
		$query = "SELECT COUNT(*) FROM category WHERE podcat_id = $id";
		$res = mysql_query($query);
		$row = mysql_fetch_row($res);
		if($row[0])
		{
			$_SESSION['edit']['res'] = "<div class='error'>Категория имеет подкатегории! Удалите сначала их или переместите в другую категорию.</div>";
		}
		else
		{
			mysql_query("DELETE FROM goods WHERE cat_id = $id");
			mysql_query("DELETE FROM category WHERE cat_id = $id");
			$_SESSION['edit']['res'] = "<div class='error'>Категория удалена.</div>";
		}
	}
else
{
$result = mysql_query("SELECT * FROM category WHERE cat_id=$id");      
$myrow = mysql_fetch_array($result);

print <<<HERE

<form name="editcat" method="post">
		 <p>
		   <label>Введите название категории<br>
			 <input type="text" name="name" required value="$myrow[name]">
			 </label>
		 </p>
		 <p>
		   <label>Выберите категорию из списка<br>
		   <select name="podcat_id" required >
			<option value="0">Самостоятельная категория</option>
HERE;
			$res1 = mysql_query("SELECT cat_id,name FROM category",$db);
				while($cat = mysql_fetch_array($res1))
				{  
					echo "<option value='".$cat['cat_id']."'>".$cat['name']."</option>";
				}
		echo "</select>
		   </label>
		 </p>
		 <p>
		   <label>Ссылка на изображение<br>
		   <input type='text' name='img' value='".$myrow[img]."'>
		   </label>
		 </p>
		 </p>
		 <input name='cat_id' type='hidden' value='".$myrow[cat_id]."'>
         <p>
		 <p>
		   <label>
		   <input type='submit' name='editcat' value='Изменить категорию'>
		   </label>
		 </p>
</form>";
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