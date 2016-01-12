<?php if(local) die('error'); ?>
<div class="content">
<?php
	if (!isset($_GET['id']))
	{
		echo "<h2 align='center'>Редактирование пользователей</h2>";
		echo "<p>Чтобы отредактировать пользователя, нажмите по его имени.</p><br>";
		$result = mysql_query("SELECT login,customer_id FROM customers");      
		$myrow = mysql_fetch_array($result);
		echo "<table border='0' align='center' cellspacing='2' cellpadding='4'>
		  <tr>
			<th>Имя пользователя</th>
			<th>Действие</th>
		  </tr>";
		do 
		{
		printf ("<tr><td><a href='index.php?page=edituser&id=%s'>%s</a></td><td><a href='index.php?page=edituser&id=%s&deluser'>Удалить</a></td></tr>",$myrow["customer_id"],$myrow["login"],$myrow["customer_id"]);
		}

		while ($myrow = mysql_fetch_array($result));
		echo "</table>";
	}

else

{
	$id=$_GET['id'];
	if(isset($_GET['deluser']))
	{ 
		
		if (isset($id))
		{
		$result = mysql_query ("DELETE FROM customers WHERE customer_id='$id'");

		if ($result == 'true') $_SESSION['edit']['res'] = "Пользователь успешно удален!";
		else $_SESSION['edit']['res'] = "Пользователь не удален!";

		}		 
		else 

		{
		$_SESSION['edit']['res'] = "Вы запустили данный фаил без параметра id";
		}
	}
else
{
$result = mysql_query("SELECT * FROM customers WHERE customer_id=$id");      
$myrow = mysql_fetch_array($result);
print <<<HERE

<form name="edituser" method="post">
		<table width="421" height="125">
		<tr>
			<td width="180"><label for="login">*Логин:</label></td>
			<td width="225"><input type="text" value="$myrow[login]" name="login"/></td>
		</tr>
		<tr>
			<td><label for="password">*Новый пароль</label></td>
			<td><input type="password" name="password" placeholder="Пароль"/></td>
		</tr>
		<tr>
			<td><label for="name">*ФИО</label></td>
			<td><input type="text" required  name="name" placeholder="Васечкин Петр Сергеевич" value="$myrow[name]"/></td>
		</tr>
		<tr>
			<td><label for="email">*E-mail</label></td>
			<td><input type="text" required  name="email" placeholder="test@mail.ru" value="$myrow[email]"/></td>
		</tr>
		<tr>
			<td><label for="phone">*Телефон</label></td>
			<td><input type="text" required  name="phone" placeholder="89619999299" value="$myrow[phone]"/></td>
		</tr>
		<tr>
			<td><label for="address">*Адрес доставки</label></td>
			<td><input type="text" required  name="address" placeholder="ул. Трудовая 8, комната 167" value="$myrow[address]"/></td>
		</tr>
		<input name="customer_id" type="hidden" value="$myrow[customer_id]">
	  </table> 
	  <p>
		<input type="submit" name="edituser" value="Изменить настройки пользователя">
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