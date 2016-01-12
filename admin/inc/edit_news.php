<?php if(local) die('error'); ?>
<div class="content">
<?php
	if (!isset($_GET['id']))
	{
		echo "<h2 align='center'>Редактирование новостей</h2>";
		echo "<p>Чтобы отредактировать новость, нажмите на её название.</p><br>";
		$result = mysql_query("SELECT title,news_id FROM news");      
		$myrow = mysql_fetch_array($result);
		echo "<table border='0' align='center' cellspacing='2' cellpadding='4'>
		  <tr>
			<th>Название новости</th>
			<th>Действие</th>
		  </tr>";
		do 
		{
		printf ("<tr><td><a href='index.php?page=editnews&id=%s'>%s</a></td><td><a href='index.php?page=editnews&id=%s&delnews'>Удалить</a></td></tr>",$myrow["news_id"],$myrow["title"],$myrow["news_id"]);
		}

		while ($myrow = mysql_fetch_array($result));
		echo "</table>";
	}

else

{
	$id = $_GET['id'];
	if(isset($_GET['delnews']))
	{
		if (isset($id))
		{
		$result = mysql_query ("DELETE FROM news WHERE news_id='$id'");

		if ($result == 'true') $_SESSION['edit']['res'] = "Ваша новость успешно удалена!";
		else $_SESSION['edit']['res'] = "Ваша новость не удалена!";

		}		 
		else 

		{
		$_SESSION['edit']['res'] = "Вы запустили данный фаил без параметра id";
		}
	}
else
{
$result = mysql_query("SELECT * FROM news WHERE news_id=$id");      
$myrow = mysql_fetch_array($result);

print <<<HERE

<form name="editnews" method="post">
         <p>
           <label>Введите название новости<br>
             <input value="$myrow[title]" type="text" name="title" id="title">
             </label>
         </p>
         <p>
           <label>Введите краткое описание новости<br>
           <input value="$myrow[anons]" type="text" name="anons">
           </label>
         </p>
         <p>
           <label>Введите дату добавления новости<br>
           <input value="$myrow[date]" name="date" type="date" value="2014-05-09">
           </label>
         </p>
         <p>
           <label>Введите полный текст новости с тэгами<br>
           <textarea name="text" id="text" cols="40" rows="20">$myrow[text]</textarea>
           </label>
         </p>
		 <input name="news_id" type="hidden" value="$myrow[news_id]">
		 
         <p>
           <label>
           <input type="submit" name="editnews" value="Сохранить изменения">
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