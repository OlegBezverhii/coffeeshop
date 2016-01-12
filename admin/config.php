<?php
/*echo "Connect BD";*/
$db = mysql_connect("localhost","root","");

if (!$db) {
    die('Oshubka : ' . mysql_error());
}

mysql_select_db("kursac",$db);

function teg($var)
{
    $var = mysql_real_escape_string(trim($var));
    return $var;
}

if(isset($_POST['addnews']))
{
	if (isset($_POST['title'])) {$title = $_POST['title']; 	if ($title == '') {unset($title);}}
	if (isset($_POST['date']))  {$date = $_POST['date']; if ($date == '') {unset($date);}}
	if (isset($_POST['text']))  {$text = $_POST['text']; if ($text == '') {unset($text);}}
	if (isset($_POST['anons'])) {$anons = $_POST['anons']; if ($anons == '') {unset($anons);}}

	if (isset($title) && isset($date) && isset($text) && isset($anons))
	{
		$result = mysql_query ("INSERT INTO news (title,date,text,anons) VALUES ('$title','$date','$text','$anons')");

		if ($result == 'true')
		{$_SESSION['edit']['res'] = "Ваша новость успешно добалена!";}
		else 
		{$_SESSION['edit']['res'] = "Ваша новость не добалена!";}
	}
	else
	{ 
		$_SESSION['edit']['res'] = "Вы заполнили не все поля";
	}
}

if(isset($_POST['addart']))
{	
	if (isset($_POST['title'])) {$title = $_POST['title']; 	if ($title == '') {unset($title);}}
	if (isset($_POST['text'])) {$text = $_POST['text']; if ($text == '') {unset($text);}}
	if (isset($_POST['description'])) {$description = $_POST['description']; if ($description == '') {unset($description);}}
	
	if (isset($title) && isset($text) && isset($description))
	{
		/*Здесь пишем что можно заносить информацию в базу */
		$result = mysql_query ("INSERT INTO articles (title,text,description) VALUES ('$title','$text','$description')");

		if ($result == 'true')
		{$_SESSION['edit']['res'] = "Ваша статья успешно добалена!";}
		else {$_SESSION['edit']['res'] = "Ваша статья не добалена!";}
	}
	else
	{ 
		$_SESSION['edit']['res'] = "Вы заполнили не все поля";
	}
}

if(isset($_POST['addcat']))
{	
	$name = teg($_POST['name']);
    $podcat_id = (int)$_POST['podcat_id'];
    
    if(empty($name))
	{
        $_SESSION['edit']['res'] = "<div class='error'>Вы не указали название категории</div>";
    }
	else
	{
        // проверяем нет ли такой категории на одном уровне
        $query = "SELECT cat_id FROM category WHERE name = '$name' AND podcat_id = $podcat_id";
        $res = mysql_query($query);
        if(mysql_num_rows($res) > 0)
		{
            $_SESSION['edit']['res'] = "<div class='error'>Категория с таким названием уже есть</div>";
        }
		else
		{
            $query = "INSERT INTO category (name, podcat_id)
                        VALUES ('$name', $podcat_id)";
            $res = mysql_query($query);
            if(mysql_affected_rows() > 0)
			{
                $_SESSION['edit']['res'] = "<div class='success'>Категория добавлена!</div>";
            }
			else
			{
                $_SESSION['edit']['res'] = "<div class='error'>Ошибка при добавлении категории!</div>";
            }                        
        }
    }
}

if(isset($_POST['adduser']))
{	
	//echo "Dannue otpravuluc'";
	$error = ''; // пустое поле
	//echo "My login1 is ".$_POST['login'];

	// trim - убираем пробелы спереди и сзади, strip_tags - вырезает php и html теги
	$login = teg($_POST['login']);
	$pass = trim($_POST['password']);
	$name = teg($_POST['name']);
	$email = teg($_POST['email']);
	$phone = teg($_POST['phone']);
	$address = teg($_POST['address']);

	if(empty($login)) $error .= '<li>Не указан логин</li>';
	if(empty($pass)) $error .= '<li>Не указан пароль</li>';
	if(empty($name)) $error .= '<li>Не указано ФИО</li>';
	if(empty($email)) $error .= '<li>Не указан E-mail</li>';
	if(empty($phone)) $error .= '<li>Не указан телефон</li>';
	if(empty($address)) $error .= '<li>Не указан адрес</li>';

	if(!empty($login))
	{
	if(strlen($login)>20 or strlen($login)< 5)
	{$error .= '<li>Логин не должен быть меньше 5 и больше 20 символов</li>';}
	}

	if(!empty($email))
	{
		if(preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $email)) 
		{}
		else
		{
		 $error .= '<li>Указаный E-mail не соотвествует маске</li>';
		}
	}

	if(empty($error))
	{
	// если отсутствуют ошибки
	$query = "SELECT customer_id FROM customers WHERE login = '$login'";
	$res = mysql_query($query) or die(mysql_error());
	$row = mysql_num_rows($res); // Выведем количество записей юзеров по данному запросу: если 1 - такой юзер есть, 0 - нет
	if($row)
		{
			$_SESSION['reg']['res'] = "<div class='ok'>Пользователь с таким логином уже зарегистрирован на сайте. Введите другой логин.</div>";
			$_SESSION['reg']['name'] = $name;
			$_SESSION['reg']['email'] = $email;
			$_SESSION['reg']['phone'] = $phone;
			$_SESSION['reg']['addres'] = $address;
		}
	else
		{
			// если все ок - регистрируем
			$pass = md5($pass);
			$query = "INSERT INTO customers (name, email, phone, address, login, password)
						VALUES ('$name', '$email', '$phone', '$address', '$login', '$pass')";
			$res = mysql_query($query) or die(mysql_error());
			if(mysql_affected_rows() > 0) //если число затронутых прошлой операцией рядов ($res)
			{
				// если запись добавлена
				$_SESSION['reg']['res'] = "<div class='success'>Пользователь успешно добавлен.</div>";
			}
		}
	}
	else
	{
	// если не заполнил поля
	$_SESSION['reg']['res'] = "Выявлены следующие ошибки: <ul> $error </ul>";
	$_SESSION['reg']['login'] = $login;
	$_SESSION['reg']['name'] = $name;
	$_SESSION['reg']['email'] = $email;
	$_SESSION['reg']['phone'] = $phone;
	$_SESSION['reg']['addres'] = $address;
	}
}

if(isset($_POST['addgoods']))
{	
	if (isset($_POST['name'])) {$name = $_POST['name']; 	if ($name == '') {unset($name);}}
	if (isset($_POST['img'])) {$img = $_POST['img']; 	if ($img == '') {unset($img);}}
	if (isset($_POST['price'])) {$price = $_POST['price']; 	if ($price == '') {unset($price);}}
	if (isset($_POST['inv'])) {$inv= $_POST['inv']; 	if ($inv == '') {unset($inv);}}
	if (isset($_POST['visible'])) {$visible = $_POST['visible']; 	if ($visible == '') {unset($visible);}}
	if (isset($_POST['cat_id'])) {$cat_id = $_POST['cat_id']; 	if ($cat_id == '') {unset($cat_id);}}
	if (isset($_POST['text'])) {$text = $_POST['text']; 	if ($text == '') {unset($text);}}
	
	if (isset($name) && isset($img) && isset($price) && isset($inv) && isset($visible) && isset($cat_id) && isset($text))
	{
		/*Здесь пишем что можно заносить информацию в базу */
		$result = mysql_query ("INSERT INTO goods (name,img,price,inv,visible,cat_id,text) VALUES ('$name','$img','$price','$inv','$visible','$cat_id','$text')");

		if ($result == 'true')
		{$_SESSION['edit']['res'] = "Товар успешно добален!";}
		else {$_SESSION['edit']['res'] = "Товар не добален!";}
	}
	else
	{ 
		$_SESSION['edit']['res'] = "Вы заполнили не все поля";
	}
}

if(isset($_POST['editnews']))
{
	if (isset($_POST['title'])) {$title = $_POST['title']; 	if ($title == '') {unset($title);}}
	if (isset($_POST['date']))  {$date = $_POST['date']; if ($date == '') {unset($date);}}
	if (isset($_POST['text']))  {$text = $_POST['text']; if ($text == '') {unset($text);}}
	if (isset($_POST['anons'])) {$anons = $_POST['anons']; if ($anons == '') {unset($anons);}}
	if (isset($_POST['news_id'])) {$news_id = $_POST['news_id']; if ($news_id == '') {unset($news_id);}}
	
	if (isset($title) && isset($date) && isset($text) && isset($anons) && isset($news_id))
	{
		$result = mysql_query ("UPDATE news SET title = '$title', date = '$date', text = '$text', anons = '$anons' WHERE news_id ='$news_id'");

		if ($result == 'true')
		{ $_SESSION['edit']['res'] = "Ваша новость успешно изменена!";}
		else 
		{$_SESSION['edit']['res'] = "Что-то пошло не так!";}
	}
	else
	{ 
		$_SESSION['edit']['res'] = "Вы заполнили не все поля";
	}
}

if(isset($_POST['editart']))
{
	if (isset($_POST['title'])) {$title = $_POST['title']; 	if ($title == '') {unset($title);}}
	if (isset($_POST['text'])) {$text = $_POST['text']; if ($text == '') {unset($text);}}
	if (isset($_POST['description'])) {$description = $_POST['description']; if ($description == '') {unset($description);}}
	if (isset($_POST['id'])) {$id = $_POST['id']; if ($id == '') {unset($id);}}
	
	if (isset($title) && isset($description) && isset($text) && isset($id))
	{
		$result = mysql_query ("UPDATE articles SET title = '$title', description = '$description', text = '$text' WHERE id ='$id'");

		if ($result == 'true')
		{ $_SESSION['edit']['res'] = "Ваша статья успешно изменена!";}
		else 
		{$_SESSION['edit']['res'] = "Что-то пошло не так!";}
	}
	else
	{ 
		$_SESSION['edit']['res'] = "Вы заполнили не все поля";
	}
}

if(isset($_POST['edituser']))
{
		$error = ''; // пустое поле
		$login = teg($_POST['login']);
		$password = trim($_POST['password']);
		$name = teg($_POST['name']);
		$email = teg($_POST['email']);
		$phone = teg($_POST['phone']);
		$address = teg($_POST['address']);
		$customer_id = $_POST['customer_id'];
		
		if(empty($login)) $error .= '<li>Не указан логин</li>';
		if(empty($name)) $error .= '<li>Не указано ФИО</li>';
		if(empty($email)) $error .= '<li>Не указан E-mail</li>';
		if(empty($phone)) $error .= '<li>Не указан телефон</li>';
		if(empty($address)) $error .= '<li>Не указан адрес</li>';

		if(!empty($login))
		{
			if(strlen($login)>20)
			{$error .= '<li>Логин не должен быть больше 20 символов</li>';}
		}
		
		if(!empty($email))
		{
			if(preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $email)) 
			{}
			else
			{
			 $error .= '<li>Указаный E-mail не соотвествует маске</li>';
			}
		}
		
		if(empty($error))
		{
			$res = mysql_query("SELECT customer_id FROM customers WHERE customer_id = '$customer_id'");
			$res2 = mysql_fetch_array($res);
			$row = mysql_num_rows($res);
			//echo "Kol-vo zapucei ".$row;
			if($row == 1)
			{
				if(empty($password))
				{
					$query = "UPDATE customers SET name = '$name', email = '$email', phone = '$phone', address = '$address', login = '$login' WHERE customer_id ='$customer_id'";
					$res = mysql_query($query) or die(mysql_error());
					if(mysql_affected_rows() > 0) //если число затронутых прошлой операцией рядов ($res)
					{
						// если запись добавлена
						$_SESSION['edit']['res'] = "<div class='success'>Информация об аккаунте изменена.</div>";
					}
				}
				else
				{	
					$password = md5($password);
					$query = "UPDATE customers SET name = '$name', email = '$email', phone = '$phone', address = '$address', login = '$login', password = '$password' WHERE customer_id ='$customer_id'";
					$res = mysql_query($query) or die(mysql_error());
					if(mysql_affected_rows() > 0) //если число затронутых прошлой операцией рядов ($res)
					{
						// если запись добавлена
						$_SESSION['edit']['res'] = "<div class='success'>Информация об аккаунте изменена.</div>";
					}
				}
			}
			else
			{ $_SESSION['edit']['res'] = "<div class='error'>Что-то пошло не так.</div>";}
		}
		else
		{
			// если не заполнил поля
			$_SESSION['edit']['res'] = "Выявлены следующие ошибки: <ul> $error </ul>";
			$_SESSION['edit']['login'] = $login;
			$_SESSION['edit']['name'] = $name;
			$_SESSION['edit']['email'] = $email;
			$_SESSION['edit']['phone'] = $phone;
			$_SESSION['edit']['addres'] = $address;
    	}
}

if(isset($_POST['editcat']))
{
	$name = teg($_POST['name']);
    $podcat_id = (int)$_POST['podcat_id'];
	$cat_id = (int)$_POST['cat_id'];
	$img = teg($_POST['img']);
    
    if(empty($name))
	{
        $_SESSION['edit']['res'] = "<div class='error'>Вы не указали название категории</div>";
    }
	
	else
	{
        // проверяем нет ли такой категории на одном уровне
        $query = "SELECT cat_id FROM category WHERE name = '$name' AND podcat_id = $podcat_id";
        $res = mysql_query($query);
        if(mysql_num_rows($res) > 0)
		{
            $_SESSION['edit']['res'] = "<div class='error'>Категория с таким названием уже есть</div>";
        }
		else
		{
			if($podcat_id != $cat_id)
			{	$query = "UPDATE category SET name = '$name', podcat_id = '$podcat_id', img = '$img' WHERE cat_id = $cat_id";
				$res = mysql_query($query);
				if(mysql_affected_rows() > 0)
				{
					$_SESSION['edit']['res'] = "<div class='success'>Категория изменена!</div>";
				}
				else
				{
					$_SESSION['edit']['res'] = "<div class='error'>Ошибка при изменении категории!</div>";
				}  
			}
			else
			{
				$_SESSION['edit']['res'] = "<div class='success'>Категория не может быть подкатегорией самой себе.</div>";
			}
        }
    }
}

if(isset($_POST['editgoods']))
{	
	if (isset($_POST['name'])) {$name = $_POST['name']; 	if ($name == '') {unset($name);}}
	if (isset($_POST['img'])) {$img = $_POST['img']; 	if ($img == '') {unset($img);}}
	if (isset($_POST['price'])) {$price = $_POST['price']; 	if ($price == '') {unset($price);}}
	if (isset($_POST['inv'])) {$inv= $_POST['inv']; 	if ($inv == '') {unset($inv);}}
	if (isset($_POST['visible'])) {$visible = $_POST['visible']; 	if ($visible == '') {unset($visible);}}
	if (isset($_POST['cat_id'])) {$cat_id = $_POST['cat_id']; 	if ($cat_id == '') {unset($cat_id);}}
	if (isset($_POST['text'])) {$text = $_POST['text']; 	if ($text == '') {unset($text);}}
	if (isset($_POST['goods_id'])) {$goods_id = $_POST['goods_id']; if ($goods_id == '') {unset($goods_id);}}
	
	if (isset($name) && isset($img) && isset($price) && isset($inv) && isset($visible) && isset($cat_id) && isset($text) && isset($goods_id))
	{
		/*Здесь пишем что можно заносить информацию в базу */
		$result = mysql_query ("UPDATE goods SET name ='$name',img='$img',price ='$price',inv ='$inv',visible ='$visible',text ='$text',cat_id='$cat_id' WHERE goods_id ='$goods_id'");

		if ($result == 'true')
		{$_SESSION['edit']['res'] = "Товар успешно изменён!";}
		else {$_SESSION['edit']['res'] = "Товар не изменился, что то пошло не так!";}
	}
	else
	{ 
		$_SESSION['edit']['res'] = "Вы заполнили не все поля";
	}
}

function show_order($order_id)
{
    $query="SELECT goods.price, goods.name, zakaz_tovar.quantity, orders.date, orders.prim, orders.status, customers.name AS customer, customers.email, customers.phone, customers.address FROM zakaz_tovar LEFT JOIN orders ON zakaz_tovar.orders_id = orders.order_id LEFT JOIN customers ON customers.customer_id = orders.customer_id LEFT JOIN goods ON zakaz_tovar.goods_id = goods.goods_id WHERE zakaz_tovar.orders_id =$order_id";
    $res = mysql_query($query);
    $show_order = array();
    while($row = mysql_fetch_assoc($res))
	{
        $show_order[] = $row;
    }
    return $show_order;
}
?>
