<?php if(local) die('error'); ?>
		</div>
        <div id="content" class="float_r">
        	<!--<h2>Редактирование аккаунта</h2>-->
			<?php if(!$_SESSION['auth']['user']): ?>
			<p>Вы не авторизованы, войдите пожалуйста.</p>
			<?php else: ?>
			<?php $orig=user(); ?>
				<p><h4>Вы вошли под <strong><?=$orig['login'];?></strong></h4></p>
				<h2>Изменение контактной информации</h2>
				<form id="editcontact" name="editcontact" method="post" style="color: black;">
					<table width="421" height="125">
					<tr>
						<td width="180"><label for="login">*Логин:</label></td>
						<td width="225"><input type="text" required  name="login" maxlength="20" value="<?=$orig['login'];?>" placeholder="User14" /></td>
					</tr>
					<tr>
						<td><label for="name">*ФИО</label></td>
						<td><input type="text" required  name="name" value="<?=$orig['name'];?>" placeholder="Васечкин Петр Сергеевич" /></td>
					</tr>
					<tr>
						<td><label for="email">*E-mail</label></td>
						<td><input type="text" required  name="email" value="<?=$orig['email'];?>" placeholder="test@mail.ru" /></td>
					</tr>
					<tr>
						<td><label for="phone">*Телефон</label></td>
						<td><input type="text" required  name="phone" value="<?=$orig['phone'];?>" placeholder="89619999299"/></td>
					</tr>
					<tr>
						<td><label for="address">*Адрес доставки</label></td>
						<td><input type="text" required  name="address" value="<?=$orig['address'];?>" placeholder="ул. Трудовая 8, комната 167"/></td>
					</tr>
				  </table> 
                  <p>
                    <input type="submit" name="editcontact" value="Изменить информацию">
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
				</br>
				<h2>Изменение пароля</h2>
                <form id="editpass" name="editpass" method="post" style="color: black;">
                  <table width="421" height="125">
                  <tr>
                    <td width="180"><label for="password">Текущий пароль:</label></td>
                    <td width="225"><input type="password" name="old_passwd" placeholder="Текущий пароль" required></td>
                  </tr>
				  <tr>
                    <td><label for="new_passwd">Новый пароль:</label></td>
                    <td><input name="new_passwd" type="password" placeholder="Новый пароль" required></td>
                  </tr>
				  <tr>
                    <td><label for="new_passwd2">Потверждение нового пароля:</label></td>
                    <td><input type="password" name="new_passwd2" placeholder="Новый пароль" required></td>
                  </tr>
				  </table> 
                  <p>
                    <input type="submit" name="editpass" value="Изменить пароль">
                  </p>
                </form>
				<?php 	
					if(isset($_SESSION['edit1']['res']))
					{
						echo '<div class="error">' .$_SESSION['edit1']['res']. '</div>';
						unset($_SESSION['edit1']['res']);
					} 
				?>
          <br>
		  <?php endif; ?>   	
        </div> 
        <div class="cleaner"></div>