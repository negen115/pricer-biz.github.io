<?php
require_once 'connection.php';
$sql = mysql_connect($host, $user, $password, $database)

if (!$sql) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
else {
	mysql_select_db($database);
	mysql_query("SET NAMES utf8");
	mysql_query("SET CHARACTER SET utf8");
}

require 'simple_html_dom.php';
$i = $_GET['index'];

// Create DOM from URL or file
$html = file_get_html('http://www.blagovest-moskva.ru/catalog125_1.html');

// Количество страниц каталога
$element=$html->find('.pages', 0);
	   $col=count($element->children());

$file = 'result.csv';

if ($i=='1') {
	$fp = fopen ($file, "w");
	mysql_query("DELETE FROM `res_pars`");
} else {
	$fp = fopen ($file, "a");
	}

	$html = file_get_html('http://www.blagovest-moskva.ru/catalog125_'.$i.'.html'); // Страница каталога товаров


	foreach($html->find('.pic_item a') as $element) {
				$link='http://www.blagovest-moskva.ru'.$element->href; // ссылка на страницу товара
				$html_child = file_get_html($link); // страница товара
				foreach($html_child->find('.descr') as $res) {
					$tmpISBN=$res->plaintext;
					$pos = strripos($tmpISBN, 'ISBN: ');
					$ISBN=substr($tmpISBN,$pos+6,17);
					if (preg_match("/[^0-9-]/", $ISBN)) {
						$ISBN = '';}
				}
				foreach($html_child->find('.lline h1') as $res) {
					$nazv=$res->plaintext;
				}

				foreach($html_child->find('span[itemprop=price]') as $res) {
					$price=$res->plaintext;
					$price = preg_replace("/[^0-9.]/", '', $price);
				}
			
				
				$html_child->clear(); // очитска переменной
				unset($html_child);
			$output = $ISBN.';'.$nazv.';'.$price.';'.$link;
			
			fwrite($fp, iconv('UTF-8', 'Windows-1251', $output)."\r\n");

			$query = "INSERT INTO res_pars (isbn, name, price, link)
						VALUES ('".$ISBN."','".$nazv."','".$price."','".$link."');";
			$result = mysql_query($query);


	 $nazv=$price=$link='';
	}

fclose($fp);
				$html->clear(); // очистка переменной
				unset($html_child);

if (!$result) {
    die('Неверный запрос: ' . mysql_error());
}
echo $result;
mysqli_close($sql);

?>