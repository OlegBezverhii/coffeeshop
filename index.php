<?php
session_start();
include "config.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Кофейня "У Олега"</title>
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="nivo-slider.css" type="text/css" media="screen" />

<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/ddsmoothmenu.js">

/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>

<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "top_nav", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

</script>

<script type="text/javascript" src="js/jquery-1.4.3.min.js"></script> 
<link rel="stylesheet" href="css/slimbox2.css" type="text/css" media="screen" /> 
<script type="text/JavaScript" src="js/slimbox2.js"></script> 


</head>

<body>

<div id="templatemo_body_wrapper">
<div id="templatemo_wrapper">

	<div id="templatemo_header">
    	<h2 style="text-align: center;color: white;">Кофейня "У Олега"</h2>
		<!--<div id="site_title"><h1><a href="http://shop.com"></a></h1></div>
        <div id="header_right">
        	<p>
	        <a href="http://shop.com/index.php?page=editpass">Мой аккаунт</a> | <a href="#">My Wishlist</a> | <a href="#">My Cart</a> | <a href="#">Checkout</a> | <a href="?do=logout">Log In</a>
			</p>
		</div>-->
        <div class="cleaner"></div>
    </div> <!-- END of templatemo_header -->
    
    <div id="templatemo_menubar">
    	<div id="top_nav" class="ddsmoothmenu">
            <ul>
			    <li><a href="index.php">Главная</a></li>
			    <li><a href="?page=articles">Статьи</a></li>
				<li><a href="?page=shop">Магазин</a>
                    <ul>
<?php
$res1 = mysql_query("SELECT * FROM category WHERE podcat_id=0",$db);

while($cat = mysql_fetch_array($res1))
{echo "<li><a href='?page=shop&category=".$cat['cat_id']."'>".$cat['name']."</a></li>";}
?>
                   </ul>
                </li>
				<li><a href="?page=oplata">Заказать</a></li>
				<li><a href="?page=about">О компании</a></li>
                <!--<li><a href="?page=recept">Рецепты</a></li>
                <li><a href="checkout.html">Checkout</a></li>
                <li><a href="contact.html">Contact Us</a></li>-->
            </ul>
            <br style="clear: left" />
        </div> <!-- end of ddsmoothmenu -->
        <div id="templatemo_search">
            <form method="get">
              <input type="text" value=" " name="keyword" id="keyword" title="keyword" onfocus="clearText(this)" onblur="clearText(this)" class="txt_field" />
              <input type="submit" name="search" value=" " alt="Search" id="searchbutton" title="Search" class="sub_btn"  />
            </form>
        </div>
    </div> <!-- END of templatemo_menubar -->
    
    <div id="templatemo_main">
		<div id="sidebar" class="float_l">
        	<div class="sidebar_box"><span class="bottom"></span>
				<h3>Авторизация</h3>
				<div class="content"> 				
				<?php if(!$_SESSION['auth']['user']): ?>
				<form method="post">
					<label for="login">Логин: </label><br />
					<input type="text" name="login" required maxlength="20" id="login" placeholder="Логин"/><br />
					<label for="pass">Пароль: </label><br />
					<input type="password" name="pass" required id="pass" placeholder="Пароль"/><br />
					<input type="submit" name="auth" id="auth" value="Войти" /><br /><p></p>
					<p class="link"><a href="?page=reg">Регистрация</a></p>
				</form>
				<?php 
					if(isset($_SESSION['auth']['error']))
					{
						echo $_SESSION['auth']['error'];
						unset($_SESSION['auth']);
					}
				?>
				<?php else: ?>
					<p>Добро пожаловать, <?=$_SESSION['auth']['user']?></p>
					<p><a href="?page=editpass">Изменить пароль</a></p>
					<a href="?do=logout">Выход</a>
				<?php endif; ?>
				</div>
            </div>
            <!--<div class="sidebar_box"><span class="bottom"></span></div>-->
		<?php
		/*Объявил именованную константу 'locale' с параметром false*/
		define('local', false);
		/*Объявил переменную page и приравняли к $_GET Это 'суперглобальная' или автоматическая глобальная переменная. Массивы $_GET и $_POST*/
		$keyword = $_GET['keyword'];
		
		$page = $_GET['page'];
		switch($page){
			case 'articles':
			include "inc/articles.php"; 
			break;
			
			case 'shop':
			include "inc/shop.php"; 
			break;
			
			case 'oplata':
			include "inc/oplata.php"; 
			break;		
			
			case 'about':
			include "inc/about.php"; 
			break;
			
			case 'reg':
			include "inc/reg.php"; 
			break;
			
			case 'editpass':
			include "inc/editpass.php"; 
			break;
			
			case 'recept':
			include "inc/recept.php"; 
			break;
					
			default:
			if(isset($_GET['keyword']))
			include "inc/search.php"; 
			else
			include "inc/home.php"; 
			break;
			}
			
		?>
    </div> <!-- END of templatemo_main -->
    
    <div id="templatemo_footer">
    	<p><a href="index.php">Главная</a> | <a href="?page=articles">Статьи</a> | <a href="?page=shop">Магазин</a> | <a href="?page=about">О компании</a> | <a href="http://shop.com/admin/index.php">Панель администратора</a>
		</p>

    	Copyright © 2014 <a href="http://bgpu.ru">Oleg Bezverhii</a> | <a href="http://www.templatemo.com/preview/templatemo_367_shoes">Shoes Theme</a> by <a href="http://www.templatemo.com" target="_parent" title="free css templates">templatemo</a></div> <!-- END of templatemo_footer -->
    
</div> <!-- END of templatemo_wrapper -->
</div> <!-- END of templatemo_body_wrapper -->

</body>
</html>