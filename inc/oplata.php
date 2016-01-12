<?php if(local) die('error'); ?>
		</div>
        <div id="content" class="float_r">
			<?php //print_r($_SESSION);?>
			<h1>Корзина покупок</h1>
			<?php if(isset($_SESSION['order']['res']))
			{
				echo "<p><h5>";
				echo $_SESSION['order']['res'];
				echo "</h5></p>";
			}
			?>
        	<?php if($_SESSION['cart']): // проверка корзины, если в корзине есть товары ?>
			<form method="post">
			<table width="680px" cellspacing="0" cellpadding="5">
                   	<tr bgcolor="#ddd">
						<th width="220" align="left">Изображение </th> 
						<th width="180" align="left">Имя </th> 
						<th width="100" align="center">Количество </th> 
						<th width="60" align="right">Цена </th> 
						<th width="60" align="right">Всего </th> 
						<th width="90"> </th>                       
                    </tr>
                    <?php foreach($_SESSION['cart'] as $key => $item): ?>	
						<tr>
                        	<td><img src="images/product/<?=$item['img']?>" width='200' height='150' alt="<?=$item['name']?>" /></td> 
                        	<td><?=$item['name']?></td> 
                            <td align="center"><input name="<?=$key?>" type="text" value="<?=$item['qty']?>" style="width: 20px; text-align: right" /> </td>
                            <td align="right"><?=$item['price']?></td> 
                            <td align="right"><?=$item['qty']*$item['price']?></td>
                            <td align="center"> <a href="?page=oplata&delete=<?=$key?>"><img src="images/remove_x.gif" alt="remove" /><!--<br />Удалить--></a> </td>
						</tr>
					<?php endforeach; ?>
						<tr>
                        	<td colspan="3" align="right"  height="30px">Изменили количество товара? Тогда нажмите сюда: <input type="submit" name="save" value="Обновить">&nbsp;&nbsp;</td>
                            <td align="right" style="background:#ddd; font-weight:bold"> Всего </td>
                            <td align="right" style="background:#ddd; font-weight:bold"><?=$_SESSION['total_sum']?></td>
                            <td style="background:#ddd; font-weight:bold">руб.</td>
						</tr>
					</table>
					</form>
                    <!--<div style="float:right; width: 215px; margin-top: 20px;">
                    
					<p><a href="checkout.html">Proceed to checkout</a></p>
                    <p><a href="javascript:history.back()">Continue shopping</a></p>
					</div><p>Avtoruzyucya</p>-->
			<p><br><br></p>
					<h2>Форма заказа</h2>
					<form method="post">
					<?php if(!$_SESSION['auth']['user']): ?>
					<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>*ФИО</td>
						<td><input type="text" required  name="name" value="<?=$_SESSION['order']['name']?>" placeholder="Васечкин Петр Сергеевич" /></td>
						<td>Пример: Васечкин Петр Сергеевич</td>
					</tr>
					<tr>
						<td>*E-mail</td>
						<td><input type="text" required  name="email" value="<?=$_SESSION['order']['email']?>" placeholder="test@mail.ru" /></td>
						<td>Пример: test@mail.ru</td>
					</tr>
					<tr>
						<td>*Телефон</td>
						<td><input type="text" required  name="phone" value="<?=$_SESSION['order']['phone']?>" placeholder="89619999299"/></td>
						<td>Пример: 8 961 999 99 99</td>
					</tr>
					<tr>
						<td>*Адрес доставки</td>
						<td><input type="text" required  name="address" value="<?=$_SESSION['order']['addres']?>" placeholder="ул. Трудовая 8, комната 167"/></td>
						<td>ул. Трудовая 8, комната 167</td>
					</tr>
					<tr>
						<td>Примечание </td>
						<td><textarea name="prim"><?=$_SESSION['order']['prim']?></textarea></td>
						<td>Если вы хотите забрать товар у нас в магазине, напишите это здесь</td>
					</tr>
					</table>
					<?php else: ?>
					<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>Примечание </td>
						<td><textarea name="prim"></textarea></td>
						<td>Если вы хотите забрать товар у нас в магазине, напишите это здесь</td>
					</tr>
					</table>
					<?php endif; ?>
					<input type="submit" name="order" value="Заказать" />
					</form>
		<?php else: // если товаров нет ?>
        Корзина пуста
		<?php endif; ?>
		<?php
		unset($_SESSION['order']);
		?>
        </div> 
        <div class="cleaner"></div>