<?php if(local) die('error'); ?>
<div class="content">
	<h2>Добавить новость</h2>
	<form name="addnews1" method="post">
			 <p>
			   <label>Введите название новости<br>
				 <input type="text" name="title">
				 </label>
			 </p>
			 <p>
			   <label>Введите краткое описание новости<br>
			   <input type="text" name="anons">
			   </label>
			 </p>
			 <p>
			   <label>Введите дату добавления новости<br>
			   <input name="date" type="date" value="2014-05-09">
			   </label>
			 </p>
			 <p>
			   <label>Введите полный текст новости с тэгами<br>
			   <textarea name="text" id="text" cols="40" rows="20"></textarea>
			   </label>
			 </p>
			 <p>
			   <label>
			   <input type="submit" name="addnews" value="Занести новость">
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