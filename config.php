<?php
/*echo "Connect BD";
Открывает соединение с сервером MySQL*/
$db = mysql_connect("localhost","root","");

if (!$db) {
    die('Не удалось соединиться : ' . mysql_error());
}

##Выбирает базу данных MySQL
mysql_select_db("kursac",$db);

define('PATH', 'http://shop.com/');
define('EMAIL', 'oleg_bezverhii@mail.ru');

##Редирект
function redirect(){
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    header("Location: $redirect");
    exit;
}

$perpage = 3; // кол-во товаров на страницу

function teg($var)
{
    $var = mysql_real_escape_string(strip_tags(trim($var)));
    return $var;
}

##Функция полной суммы корзины
function total_sum($goods)
{
    $total_sum = 0;
    
    $query = "SELECT goods_id, name, price, img
                FROM goods
                    WHERE goods_id IN (".implode(',',array_keys($goods)).")";
					
    $res = mysql_query($query) or die(mysql_error());
    
    while($row = mysql_fetch_assoc($res))
	{
        $_SESSION['cart'][$row['goods_id']]['name'] = $row['name'];
        $_SESSION['cart'][$row['goods_id']]['price'] = $row['price'];
		$_SESSION['cart'][$row['goods_id']]['img'] = $row['img'];
        $total_sum += $_SESSION['cart'][$row['goods_id']]['qty'] * $row['price'];
    }
    return $total_sum;
}

if(isset($_POST['reg']))
	{
		registration();
		//header("Location: $PATH");
	}

##Извлекаем пользователя
function user()
{
	$log = $_SESSION['auth']['user'];
	$query1 =  mysql_query("SELECT * FROM customers WHERE login = '$log'");
	$orig = mysql_fetch_array($query1);
	return $orig;
}

if(isset($_POST['editcontact']))
{
		$old=user();
		$my_id=$old['customer_id'];
		//echo "Ny id: "; echo $my_id;
		
		$error = ''; // пустое поле
		$login = teg($_POST['login']);
		$name = teg($_POST['name']);
		$email = teg($_POST['email']);
		$phone = teg($_POST['phone']);
		$address = teg($_POST['address']);
		
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
			$res = mysql_query("SELECT customer_id FROM customers WHERE login = '$login'");
			$res2 = mysql_fetch_array($res);
			//echo "Tet"; 
			$row = mysql_num_rows($res);
			echo $row;
			if($row == 0)
			{	
				// если пользователя нет меняем информацию
				$query = "UPDATE customers SET name = '$name', email = '$email', phone = '$phone', address = '$address', login = '$login' WHERE customer_id ='$my_id'";
				$res = mysql_query($query) or die(mysql_error());
				if(mysql_affected_rows() > 0) //если число затронутых прошлой операцией рядов ($res)
				{
					// если запись добавлена
					$_SESSION['edit']['res'] = "<div class='success'>Информация об аккаунте изменена.</div>";
					$_SESSION['auth']['user'] = $login;
            	}
			}
			else
			{
				if($res2['customer_id'] != $my_id) //если это не мой id пользователя -> кто то такой есть
				{
					$_SESSION['edit']['res'] = "<div class='ok'>Пользователь с таким логином уже зарегистрирован на сайте. Введите другой логин.</div>";
					$_SESSION['edit']['name'] = $name;
					$_SESSION['edit']['email'] = $email;
					$_SESSION['edit']['phone'] = $phone;
					$_SESSION['edit']['addres'] = $address;
				}
				else
				{
					// это мы, все ок - обновляем информацию
					$query = "UPDATE customers SET name = '$name', email = '$email', phone = '$phone', address = '$address', login = '$login' WHERE customer_id ='$my_id'";
					$res = mysql_query($query) or die(mysql_error());
					if(mysql_affected_rows() > 0) //если число затронутых прошлой операцией рядов ($res)
					{
						// если запись добавлена
						$_SESSION['edit']['res'] = "<div class='success'>Информация об аккаунте изменена.</div>";
						$_SESSION['auth']['user'] = $login;
					}
				}
        	}
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
	
if(isset($_POST['editpass']))
{
	$error = ''; // пустое поле
	$old=user();
	$my_id=$old['customer_id'];
		
	$old_passwd = trim($_POST[old_passwd]);
	$new_passwd = trim($_POST[new_passwd]);
	$new_passwd2 = trim($_POST[new_passwd2]);
	
	if(empty($old_passwd)) $error .= '<li>Не указан старый пароль</li>';
	if(empty($old_passwd)) $error .= '<li>Не указан новый пароль</li>';
	if(empty($old_passwd)) $error .= '<li>Не указан потверждающий пароль</li>';
	if($new_passwd != $new_passwd2) $error .= '<li>Новый пароль не совпадает с потверждающим.</li>';
	
	if(empty($error))
	{
		$old_passwd = md5($old_passwd);
		$query = "SELECT customer_id FROM customers WHERE password = '$old_passwd' AND customer_id ='$my_id'";
		$res = mysql_query($query) or die(mysql_error());
		$row = mysql_num_rows($res); // Выведем количество записей юзеров по данному запросу: если 1 - такой юзер есть, 0 - нет
		if($row == 1)
		{
			$new_passwd = md5($new_passwd);
			$query = "UPDATE customers SET password = '$new_passwd' WHERE customer_id ='$my_id'";
			$res = mysql_query($query) or die(mysql_error());
			if(mysql_affected_rows() > 0) //если число затронутых прошлой операцией рядов ($res)
			{
				// если запись добавлена
				$_SESSION['edit1']['res'] = "<p>Пароль успешно изменён</p>";
			}
		}
		else
		{
			$_SESSION['edit1']['res'] = "<p>Вы допустили ошибку в старом пароле.</p>";;
		}
	}
	else
	{
		// если ошибки
		$_SESSION['edit1']['res'] = "Выявлены следующие ошибки: <ul> $error </ul>";
	}
}
	
if(isset($_GET['clearcart']))
{
	unset($_SESSION['cart']);
	unset($_SESSION['total_sum']);
	unset($_SESSION['total_quantity']);
	redirect();
}
	##Добавление товара в корзину
//print_r($_SESSION);
// если номер товара не 0 (его не существует) и  существует переменная addtocart
	if($_GET['goods_id'] != 0 and isset($_GET['addtocart']))
	{	
		if(isset($_SESSION['cart'][$_GET['goods_id']]))
		{
			// если в массиве cart уже есть такой товар
			$_SESSION['cart'][$_GET['goods_id']]['qty'] +=1;
		}
		else
		{
			// если товар впервые добавляется
			$_SESSION['cart'][$_GET['goods_id']]['qty'] = 1;
			
		}
		
		$_SESSION['total_sum'] = total_sum($_SESSION['cart']);
		
		$_SESSION['total_quantity'] = 0;
		foreach($_SESSION['cart'] as $key => $value)
		{
			if(isset($value['price']))
			{
				//получаем количество товара
				$_SESSION['total_quantity'] += $value['qty'];				
			}
			else 
			{
				//удаляем такой ID из сессии
				unset($_SESSION['cart'][$key]);
				//echo "Petya";
			}
		}
		//echo $_SERVER['HTTP_REFERER'];
		redirect();
	}
	
	//$mass = implode(',',array_keys($_SESSION['cart']));
	##print_r(array_keys($_SESSION['cart']));
	
function registration()
{
		//echo "Dannue otpravuluc'";
		$error = ''; // пустое поле
		//echo "My login1 is ".$_POST['login'];
		
		// trim - убираем пробелы спереди и сзади, strip_tags - вырезает php и html теги
		$login = teg($_POST['login']);
		$pass = trim($_POST['pass']);
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
					$_SESSION['reg']['res'] = "<div class='success'>Регистрация прошла успешно.</div>";
					$_SESSION['auth']['customer_id'] = mysql_insert_id(); //возвращает id вставленной записи
					$_SESSION['auth']['user'] = $login;
					$_SESSION['auth']['email'] = $email;

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

if($_GET['do'] == 'logout')
{
	//echo "Ya vushel";
	unset($_SESSION['auth']['user']);
}

if($_POST['auth'])
{
		$login = mysql_real_escape_string(trim($_POST['login']));
		$pass = trim($_POST['pass']);

		//если пусты введеные значения
		if(empty($login) or empty($pass))
		{
			$_SESSION['auth']['error'] = "<div class='error'>Поля должны быть заполнены!</div>";
		}
		else
		{
			// если получил данные
			$pass = md5($pass);
			
			$query = "SELECT customer_id, login, email FROM customers WHERE login = '$login' AND password = '$pass'";
			$res = mysql_query($query) or die(mysql_error());
			if(mysql_num_rows($res) == 1) // Выведем количество записей юзеров по данному запросу: если 1 - такой юзер есть, 0 - нет
			{
				$row = mysql_fetch_row($res); //вытаскиваем строку
				$_SESSION['auth']['customer_id'] = $row[0];
				$_SESSION['auth']['user'] = $row[1];
				$_SESSION['auth']['email'] = $row[2];
			}
			else
			{
				$_SESSION['auth']['error'] = "<div class='error'>Данные введены неверно!</div>";
			}
    	}
}

if(isset($_POST['save']))
{
	foreach($_SESSION['cart'] as $key => $qty)
	{
		if($_POST[$key]=='0')
			/*echo "NULL, CYKA";else
			echo "Znachenue :".$_POST[$key]." ";*/
			unset($_SESSION['cart'][$key]);
		else
			$_SESSION['cart'][$key]['qty']=$_POST[$key];
			//echo "Znachenue :".$_POST[$key]." ";
	}
	
	$_SESSION['total_sum'] = total_sum($_SESSION['cart']);
	$_SESSION['total_quantity'] = 0;
		foreach($_SESSION['cart'] as $key => $value)
		{
			if(isset($value['price']))
			{
				//получаем количество товара
				$_SESSION['total_quantity'] += $value['qty'];				
			}
			else 
			{
				//удаляем такой ID из сессии
				unset($_SESSION['cart'][$key]);
				//echo "Petya";
			}
		}
	/*##$order = $_POST;print_r (array_keys($_POST));
	redirect();*/
}

if(isset($_GET['delete']))
{
	$id = $_GET['delete'];
	if(array_key_exists($id, $_SESSION['cart']))
	{
		$_SESSION['total_quantity'] -= $_SESSION['cart'][$id]['qty'];
		$_SESSION['total_sum'] -= $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];
		unset($_SESSION['cart'][$id]);
	}
	redirect();
}

if(isset($_POST['order']))
{
	add_order();
	//redirect;
	//echo "Ceha";
}

##Делаем заказ
function add_order(){
    // получаем общие данные
    $prim = teg($_POST['prim']);
    if(isset($_SESSION['auth']['user'])) $customer_id = $_SESSION['auth']['customer_id'];
    
    if(!$_SESSION['auth']['user'])
	{
        $error = ''; // флаг как в предыдущих функциях
    
        $name = teg($_POST['name']);
        $email = teg($_POST['email']);
        $phone = teg($_POST['phone']);
        $address = teg($_POST['address']);
        
        if(empty($name)) $error .= '<li>Не указано ФИО</li>';
        if(empty($email)) $error .= '<li>Не указан Email</li>';
        if(empty($phone)) $error .= '<li>Не указан телефон</li>';
        if(empty($address)) $error .= '<li>Не указан адрес</li>';
        
		if(!empty($email))
			{
				if(preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $email)) 
			    {}
				else
				{
				 $error .= '<li>Указаный E-mail не соотвествует маске</li>';
				}
			}
		
        if(empty($error)){
            // добавляем гостя в заказчики (но без данных авторизации)
            $customer_id = add_customer($name, $email, $phone, $address);
            if(!$customer_id) return false; // если ошибка где-то
        }else{
            // если не заполнены обязательные поля
            $_SESSION['order']['res'] = "<div class='error'>Не заполнены обязательные поля: <ul> $error </ul></div>";
            $_SESSION['order']['name'] = $name;
            $_SESSION['order']['email'] = $email;
            $_SESSION['order']['phone'] = $phone;
            $_SESSION['order']['addres'] = $address;
            $_SESSION['order']['prim'] = $prim;
            return false;
        }
    }
	$_SESSION['order']['email'] = $email;
    //$_SESSION['order']['res'] = $customer_id;
	save_order($customer_id, $prim);
}

##Добавим гостя
function add_customer($name, $email, $phone, $address){
    $query = "INSERT INTO customers (name, email, phone, address)
                VALUES ('$name', '$email', '$phone', '$address')";
    $res = mysql_query($query);
    if(mysql_affected_rows() > 0){
        // если гость добавлен в заказчики - получаем его ID
        return mysql_insert_id();
    }else{
        // если произошла ошибка при добавлении
        $_SESSION['order']['res'] = "<div class='error'>Произошла ошибка при регистрации заказа</div>";
        $_SESSION['order']['name'] = $name;
        $_SESSION['order']['email'] = $email;
        $_SESSION['order']['phone'] = $phone;
        $_SESSION['order']['addres'] = $address;
        $_SESSION['order']['prim'] = $prim;
        return false;
    }
}

##Сохранение заказа
function save_order($customer_id, $prim){
    $query = "INSERT INTO orders (`customer_id`, `date`, `prim`)
                VALUES ($customer_id, NOW(), '$prim')";
    mysql_query($query) or die(mysql_error());
    if(mysql_affected_rows() == -1){
        // если не получилось сохранить заказ - удаляем заказчика
        mysql_query("DELETE FROM customers
                        WHERE customer_id = $customer_id AND login = ''");
        return false;
    }
    $order_id = mysql_insert_id(); // ID сохраненного заказа
    
    foreach($_SESSION['cart'] as $goods_id => $value){
        $val .= "($order_id, $goods_id, {$value['qty']}),";    
    }
    $val = substr($val, 0, -1); // удаляем последнюю запятую
    
    $query = "INSERT INTO zakaz_tovar (orders_id, goods_id, quantity)
                VALUES $val";
    mysql_query($query) or die(mysql_error());
    if(mysql_affected_rows() == -1){
        // если не выгрузился заказа - удаляем заказчика (customers) и заказ (orders)
        mysql_query("DELETE FROM orders WHERE order_id = $order_id");
        mysql_query("DELETE FROM customers
                        WHERE customer_id = $customer_id AND login = ''");
        return false;
    }
    if(isset($_SESSION['auth']['email'])) $email = $_SESSION['auth']['email'];
		else  $email = $_SESSION['order']['email'];
	mail_order($order_id, $email);
	
    // если заказ выгрузился
    unset($_SESSION['cart']);
    unset($_SESSION['total_sum']);
    unset($_SESSION['total_quantity']);
    $_SESSION['order']['res'] = "<div>Спасибо за Ваш заказ. В ближайшее время мы с вами свяжемся.</div>";
    return true;
}

function mail_order($order_id, $email){
    //mail(to, subject, body, header);
    // тема письма
    $subject = "Заказ в нашей кофейне";
    // заголовки
    $headers .= "Content-type: text/plain; charset=utf-8\r\n";
    $headers .= "From: Кофейный магаз";
    // тело письма
    $mail_body = "Благодарим Вас за заказ!\r\n№ Вашего заказа - {$order_id}
    \r\n\r\nВаша корзина:\r\n";
    // атрибуты товара
    foreach($_SESSION['cart'] as $goods_id => $value){
        $mail_body .= "Имя: {$value['name']}, Цена: {$value['price']}, Количество: {$value['qty']} шт.\r\n";
    }
    $mail_body .= "\r\nИтого: {$_SESSION['total_quantity']} на сумму: {$_SESSION['total_sum']}";
    
    // отправка писем
    mail($email, $subject, $mail_body, $headers);
    mail(EMAIL, $subject, $mail_body, $headers);
}

/* ===Постраничная навигация=== */
function pagination($pages, $pages_count){
    if($_SERVER['QUERY_STRING']){ // если есть параметры в запросе
        foreach($_GET as $key => $value){
            // формируем строку параметров без номера страницы... номер передается параметром функции
           if($key != 'pages') $uri .= "{$key}={$value}&amp;";
        }  
    }
    
    // формирование ссылок
    $back = ''; // ссылка НАЗАД
    $forward = ''; // ссылка ВПЕРЕД
    $startpage = ''; // ссылка В НАЧАЛО
    $endpage = ''; // ссылка В КОНЕЦ
    $page2left = ''; // вторая страница слева
    $page1left = ''; // первая страница слева
    $page2right = ''; // вторая страница справа
    $page1right = ''; // первая страница справа
    
    if($pages > 1){
        $back = "<a class='nav_link' href='?{$uri}pages=" .($pages-1). "'>&lt;</a>";
    }
    if($pages < $pages_count){
        $forward = "<a class='nav_link' href='?{$uri}pages=" .($pages+1). "'>&gt;</a>";
    }
    if($pages > 3){
        $startpage = "<a class='nav_link' href='?{$uri}pages=1'>&laquo;</a>";
    }
    if($pages < ($pages_count - 2)){
        $endpage = "<a class='nav_link' href='?{$uri}pages={$pages_count}'>&raquo;</a>";
    }
    if($pages - 2 > 0){
        $page2left = "<a class='nav_link' href='?{$uri}pages=" .($pages-2). "'>" .($pages-2). "</a>";
    }
    if($pages - 1 > 0){
        $page1left = "<a class='nav_link' href='?{$uri}pages=" .($pages-1). "'>" .($pages-1). "</a>";
    }
    if($pages + 2 <= $pages_count){
        $page2right = "<a class='nav_link' href='?{$uri}pages=" .($pages+2). "'>" .($pages+2). "</a>";
    }
    if($pages + 1 <= $pages_count){
        $page1right = "<a class='nav_link' href='?{$uri}pages=" .($pages+1). "'>" .($pages+1). "</a>";
    }
    
    // формируем вывод навигации
    echo '<div class="pagination">' .$startpage.$back.$page2left.$page1left.'<a class="nav_active">'.$pages.'</a>'.$page1right.$page2right.$forward.$endpage. '</div>';
}
/* ===Постраничная навигация=== */

function count_rows($cat_id){
    $query = "(SELECT COUNT(goods_id) as count_rows
                 FROM goods
                     WHERE cat_id = $cat_id AND visible='1')
               UNION      
               (SELECT COUNT(goods_id) as count_rows
                 FROM goods 
                     WHERE cat_id IN 
                (
                    SELECT cat_id FROM category WHERE podcat_id = $cat_id
                ) AND visible='1')";
    $res = mysql_query($query) or die(mysql_error());
    
    while($row = mysql_fetch_assoc($res)){
        if($row['count_rows']) $count_rows = $row['count_rows'];
    }
    return $count_rows;
}
?>