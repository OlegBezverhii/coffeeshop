<?php if(local) die('error'); ?>
		</div>
        <div id="content" class="float_r">
        	<h2>Регистрация</h2>
			<form method="post">
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>*Логин</td>
						<td><input type="text" required  name="login" maxlength="20" placeholder="User14" value="<?=$_SESSION['reg']['login']?>" /></td>
						<td></td>
					</tr>
					<tr>
						<td>*Пароль</td>
						<td><input type="password" required name="pass" placeholder="Password"/></td>
						<td></td>
					</tr>
					<tr>
						<td>*ФИО</td>
						<td><input type="text" required  name="name" value="<?=$_SESSION['reg']['name']?>" placeholder="Васечкин Петр Сергеевич" /></td>
						<td>Пример: Васечкин Петр Сергеевич</td>
					</tr>
					<tr>
						<td>*E-mail</td>
						<td><input type="text" required  name="email" value="<?=$_SESSION['reg']['email']?>" placeholder="test@mail.ru" /></td>
						<td>Пример: test@mail.ru</td>
					</tr>
					<tr>
						<td>*Телефон</td>
						<td><input type="text" required  name="phone" value="<?=$_SESSION['reg']['phone']?>" placeholder="89619999299"/></td>
						<td>Пример: 8 961 999 99 99</td>
					</tr>
					<tr>
						<td>*Адрес доставки</td>
						<td><input type="text" required  name="address" value="<?=$_SESSION['reg']['addres']?>" placeholder="ул. Трудовая 8, комната 167"/></td>
						<td>ул. Трудовая 8, комната 167</td>
					</tr>                
				</table>
				<input type="submit" name="reg" value="Зарегистрироваться" />
			</form>
		<?php 	
				//
			if(isset($_SESSION['reg']['res']))
			{
				echo '<div class="error">' .$_SESSION['reg']['res']. '</div>';
				unset($_SESSION['reg']['res']);
			} 
		?>       	
        </div> 
        <div class="cleaner"></div>