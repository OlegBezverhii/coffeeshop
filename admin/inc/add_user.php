<?php if(local) die('error');?>
<div class="content">
	<h2>Добавление пользователя</h2>
	<form name="adduser" method="post">
		<table width="421" height="125">
		<tr>
			<td width="180"><label for="login">*Логин:</label></td>
			<td width="225"><input type="text" required  name="login" maxlength="20" placeholder="Логин" /></td>
		</tr>
		<tr>
			<td><label for="password">*Пароль</label></td>
			<td><input type="password" required  name="password" placeholder="Пароль" /></td>
		</tr>
		<tr>
			<td><label for="name">*ФИО</label></td>
			<td><input type="text" required  name="name" placeholder="Васечкин Петр Сергеевич" /></td>
		</tr>
		<tr>
			<td><label for="email">*E-mail</label></td>
			<td><input type="text" required  name="email" placeholder="test@mail.ru" /></td>
		</tr>
		<tr>
			<td><label for="phone">*Телефон</label></td>
			<td><input type="text" required  name="phone" placeholder="89619999299"/></td>
		</tr>
		<tr>
			<td><label for="address">*Адрес доставки</label></td>
			<td><input type="text" required  name="address" placeholder="ул. Трудовая 8, комната 167"/></td>
		</tr>
	  </table> 
	  <p>
		<input type="submit" name="adduser" value="Добавить пользователя">
	  </p>
	</form>
	</br>
	<?php 	
		if(isset($_SESSION['reg']['res']))
		{
			echo '<div class="error">' .$_SESSION['reg']['res']. '</div>';
			unset($_SESSION['reg']['res']);
		} 
	?>
</div>