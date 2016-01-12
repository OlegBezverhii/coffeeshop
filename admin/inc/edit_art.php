<?php if(local) die('error'); ?>
<div class="content">
<?php
	if (!isset($_GET['id']))
	{
		echo "<h2 align='center'>Редактирование статей</h2>";
		echo "<p>Чтобы отредактировать статью, нажмите на её название.</p><br>";
		$result = mysql_query("SELECT title,id FROM articles");      
		$myrow = mysql_fetch_array($result);
		echo "<table border='0' align='center' cellspacing='2' cellpadding='4'>
		  <tr>
			<th>Название новости</th>
			<th>Действие</th>
		  </tr>";
		do 
		{
		printf ("<tr><td><a href='index.php?page=editart&id=%s'>%s</a></td><td><a href='index.php?page=editart&id=%s&delart'>Удалить</a></td></tr>",$myrow["id"],$myrow["title"],$myrow["id"]);
		}

		while ($myrow = mysql_fetch_array($result));
		echo "</table>";
	}

else

{
$id=$_GET['id'];
	if(isset($_GET['delart']))
	{
		if (isset($id))
		{
		$result = mysql_query ("DELETE FROM articles WHERE id='$id'");

		if ($result == 'true') $_SESSION['edit']['res'] = "Ваша статья успешно удалена!";
		else $_SESSION['edit']['res'] = "Ваша статья не удалена!";

		}		 
		else 

		{
		$_SESSION['edit']['res'] = "Вы запустили данный фаил без параметра id";
		}
	}
else
{
$result = mysql_query("SELECT * FROM articles WHERE id=$id");      
$myrow = mysql_fetch_array($result);

print <<<HERE

<form name="editart" method="post">
         <p>
           <label>Введите название новости<br>
             <input value="$myrow[title]" type="text" name="title" id="title">
             </label>
         </p>
         <p>
           <label>Введите краткое описание новости<br>
           <input value="$myrow[description]" type="text" name="description">
           </label>
         </p>
         <p>
           <label>Введите полный текст новости с тэгами<br>
           <textarea name="text" id="text" cols="40" rows="20">$myrow[text]</textarea>
           </label>
         </p>
		 <input name="id" type="hidden" value="$myrow[id]">
		 
         <p>
           <label>
           <input type="submit" name="editart" value="Сохранить изменения">
           </label>
         </p>
       </form>



HERE;
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