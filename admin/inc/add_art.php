<?php if(local) die('error'); ?>
<div class="content">
	<h2>Добавить статью</h2>
		<form name="addart" method="post">
				 <p>
				   <label>Введите название статьи<br>
					 <input type="text" name="title" id="title">
					 </label>
				 </p>
				 <p>
				   <label>Введите краткое описание статьи<br>
				   <input type="text" name="description" id="description">
				   </label>
				 </p>
				 <p>
				   <label>Введите полный текст статьи с тэгами<br>
					 <textarea name="text" id="text" cols="40" rows="20"></textarea>
				   </label>
				 </p>
				 <p>
				   <label>
				   <input type="submit" name="addart" value="Добавить статью">
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
