<?php
require_once 'connection.php';
$sql = mysql_connect($host, $user, $password, $database);

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
$html = file_get_html('http://blagochestie.ru/categories/kupit-pravoslavnye-knigi-i-literaturu?page=1');

// Количество страниц каталога

$element=$html->find('.pagenumberer a', -2);
$col=$element->plaintext;


$file = 'blagochestie_ru.csv';

if ($i=='1') {
	$fp = fopen ($file, "w");
	mysql_query("DELETE FROM `blagochestie_ru`");
} else {
	$fp = fopen ($file, "a");
	}

	$html = file_get_html('http://blagochestie.ru/categories/kupit-pravoslavnye-knigi-i-literaturu?page='.$i); // Страница каталога товаров

	foreach($html->find('div[product-view-mode] a.products-view-picture-link') as $element) {
				$link=$element->href; // ссылка на страницу товара

	
				
				$html_child = file_get_html($link); // страница товара
				foreach($html_child->find('.details-briefproperties') as $res) {
					$tmpISBN=$res->first_child()->plaintext;
					if ($tmpISBN == 'ISBN:') {
						$ISBN = $res->last_child()->plaintext;
						$ISBN = preg_replace("/[^0-9-]/", '', $ISBN);
						break;
					}
				}
				
				foreach($html_child->find('h1[itemprop=name]') as $res) {
					$nazv=$res->plaintext;
					
				}

				foreach($html_child->find('.details-payment-block .price .cs-t-1 .price-number') as $res) {
					$price=$res->plaintext;
					$price = preg_replace("/[^0-9.]/", '', $price);

				}

				
				$html_child->clear(); // очитска переменной
				unset($html_child);
			$output = $ISBN.';'.$nazv.';'.$price.';'.$link;
			
			fwrite($fp, iconv('UTF-8', 'Windows-1251', $output)."\r\n");

			$query = "INSERT INTO blagochestie_ru (isbn, name, price, link)
						VALUES ('".$ISBN."','".$nazv."','".$price."','".$link."');";
			$result = mysql_query($query);


	 $nazv=$price=$link=$ISBN='';
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