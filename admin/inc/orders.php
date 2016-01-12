<?php if(local) die('error'); ?>
<div class="content">
<?php
	if (!isset($_GET['id']))
	{
		echo"<h2>Заказы </h2><p>Серым помечены выполненные заказы</p>";
		$prov = mysql_query("SELECT * FROM orders");
		if(mysql_num_rows($prov) == 0)
		{
			echo "<h3>Заказов нет.</h3>";
		}
		else
		{echo"<table cellspacing='2' cellpadding='4' border='1'>
			<tr>
				<th>№ заказа</th>
				<th>Покупатель</th>
				<th>Дата</th>
				<th>Действие</th>
			</tr>";
			$res1 = mysql_query("SELECT orders.order_id, orders.date, orders.status, customers.name FROM orders LEFT JOIN customers ON customers.customer_id = orders.customer_id",$db);
			while($cat = mysql_fetch_array($res1))
			{
				if($cat['status']==0)
				echo "<tr><td>".$cat['order_id']."</td><td>".$cat['name']."</td><td>".$cat['date']."</td><td><a href='index.php?page=orders&id=".$cat['order_id']."'>просмотр</a>&nbsp; | &nbsp;<a href='index.php?page=orders&id=".$cat['order_id']."&delorder'>удалить</a></td></tr>";
				else
				echo "<tr bgcolor='silver'><td>".$cat['order_id']."</td><td>".$cat['name']."</td><td>".$cat['date']."</td><td><a href='index.php?page=orders&id=".$cat['order_id']."'>просмотр</a>&nbsp; | &nbsp;<a href='index.php?page=orders&id=".$cat['order_id']."&delorder'>удалить</a></td></tr>";
			}
			echo"</table>";
		}
	}
	else
	{
		$id = $_GET['id'];
		if(isset($_GET['delorder']))
		{
			mysql_query("DELETE FROM orders WHERE order_id = $id");
			mysql_query("DELETE FROM zakaz_tovar WHERE orders_id = $id");
			$_SESSION['edit']['res'] = "<div class='error'>Заказ удален.</div>";
		}
		else
		{
			if(isset($_GET['okorder']))
			{
				mysql_query("UPDATE orders SET status = '1' WHERE order_id = $id");
				$_SESSION['edit']['res'] = "<div class='error'>Заказ обработан.</div>";
			}
			else
			{/*$result = mysql_query("SELECT goods.price, goods.name, zakaz_tovar.quantity, orders.date, orders.prim, orders.status, customers.name AS customer, customers.email, customers.phone, customers.address FROM zakaz_tovar LEFT JOIN orders ON zakaz_tovar.orders_id = orders.order_id LEFT JOIN customers ON customers.customer_id = orders.customer_id LEFT JOIN goods ON zakaz_tovar.goods_id = goods.goods_id WHERE zakaz_tovar.orders_id =$id");print_r ($orders);*/
			$orders=show_order($id);
			$i = 1; $total_sum = 0;
			echo "<table>";
			echo"<table cellspacing='2' cellpadding='4' border='1'>
			<tr>
				<th>№</th>
				<th>Название товара</th>
				<th>Цена</th>
				<th>Количество</th>
			</tr>";
			foreach($orders as $item)
			{
			    echo "<tr><td>".$i."</td>
					<td>".$item['name']."</td>
					<td>".$item['price']."</td>
					<td>".$item['quantity']."</td>
				</tr>";
				$i++; $total_sum += $item['price'] * $item['quantity']; 
			}
			echo "</table>";
			
			echo "<h2>Общая цена заказа: <span style='color:orange;'>".$total_sum."</span></h2>
			<h2>Дата заказа: <span style='color:orange;'>".$item['date']."</span></h2>";
			if ($item['status'] == 0)
			echo "<h2><span style='color:green;'>Заказ не обработан</span><p><a href='index.php?page=orders&id=".$id."&okorder'>Обработать</a></p></h2>";
			else echo "<h2><span style='color:red;'>Заказ уже отработан</span></h2>";
			echo "<h2>Данные покупателя:</h2><table cellpadding='2' border='1'>
				<tr>
					<th>ФИО</th>
					<th>Адрес</th>
					<th>Информация для связи</th>
					<th>Примечание</th>
				</tr>
				<tr>
					<td>".$item['customer']."</td>
					<td>".$item['address']."</td>
					<td>Email: ".$item['email']."<br>Телефон: ".$item['phone']."</td>
					<td style='text-align:left;'>".$item['prim']."</td>
				</tr>
			</table>";
			}
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