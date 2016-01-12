<?php
include "lock.php";
include "config.php";
?>
<html>
	<head>
		<title>Админка</title>
		<link type="text/css" rel="stylesheet" href="style.css"/>
	</head>
<body>
<div class="page">
		<div class="header">
		<h1>Админ панель</h1>
		</div>
	<div class="center">
			<div class="menu">
				<ul id="nav">
					<li><a href="index.php">Главная</a></li>
					<li><a>Новости</a>
						<ul>
							<li><a href="?page=addnews">Добавить</a></li>
							<li><a href="?page=editnews">Редактировать</a></li>
						</ul>
					</li>
					<li><a>Статьи</a>
						<ul>
							<li><a href="?page=addart">Добавить</a></li>
							<li><a href="?page=editart">Редактировать</a></li>
						</ul>
					</li>
					<li><a>Категории</a>
						<ul>
							<li><a href="?page=addcat">Добавить</a></li>
							<li><a href="?page=editcat">Редактировать</a></li>
						</ul>
					</li>
					<li><a>Пользователи</a>
						<ul>
							<li><a href="?page=adduser">Добавить</a></li>
							<li><a href="?page=edituser">Редактировать</a></li>
						</ul>
					</li>
					<li><a>Товары</a>
						<ul>
							<li><a href="?page=addgoods">Добавить</a></li>
							<li><a href="?page=editgoods">Редактировать</a></li>
						</ul>
					</li>
					<li><a href="?page=orders">Заказы</a></li>
				</ul>
			</div>
			<?php
			/*Объявил именованную константу 'locale' с параметром false*/
			define('local', false);
			/*Объявил переменную page и приравняли к $_GET Это 'суперглобальная' или автоматическая глобальная переменная. Массивы $_GET и $_POST*/

			$page = $_GET['page'];
			switch($page){
				case 'addnews':
				include "inc/add_news.php"; 
				break;
				
				case 'editnews':
				include "inc/edit_news.php"; 
				break;	
				
				case 'addart':
				include "inc/add_art.php"; 
				break;
				
				case 'editart':
				include "inc/edit_art.php"; 
				break;
				
				case 'adduser':
				include "inc/add_user.php"; 
				break;
				
				case 'edituser':
				include "inc/edit_user.php"; 
				break;
				
				case 'addcat':
				include "inc/add_cat.php"; 
				break;
				
				case 'editcat':
				include "inc/edit_cat.php"; 
				break;
				
				case 'addgoods':
				include "inc/add_goods.php"; 
				break;
				
				case 'editgoods':
				include "inc/edit_goods.php"; 
				break;
				
				case 'orders':
				include "inc/orders.php"; 
				break;
						
				default:
				include "inc/home.php"; 
				break;
				}
				
			?>
	<div style="clear:both;"></div>		
	</div>
		<div class="footer">
		&copy;Created by Oleg Bezverhii for BGPU
		</div>
</div>
</body>
</html>