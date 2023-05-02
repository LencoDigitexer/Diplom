<!DOCTYPE html>
<html>
<head>
	<title>Админ панель</title>
</head>
<body>
	<h1>Админ панель</h1>
	<form action="update.php" method="post">
		<input type="submit" name="update" value="Обновить данные">
	</form>
</body>
</html>


<?php

// URL-адрес HTML-страницы с таблицей
$url = 'http://stavturist.local/bronev/in.html';

// Создаем объект DOMDocument и загружаем HTML-страницу
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTMLFile($url);

// Находим таблицу на странице
$tables = $dom->getElementsByTagName('tbody');
$table = $tables->item(0);

// Создаем массив для хранения данных
$data = array();

// Получаем строки таблицы и добавляем их в массив
$rows = $table->getElementsByTagName('tr');
foreach ($rows as $row) {
    $cells = $row->getElementsByTagName('td');
    $row_data = array();
    foreach ($cells as $cell) {
        $row_data[] = $cell->nodeValue;
    }
    $data[] = $row_data;
}

// Выводим данные на экран
foreach ($data as $row) {
    echo "trip_from " . $row[0] . " date_time " .  $row[1] . " vehicle " . $row[2] . " free_seats " . $row[3] . " status " . $row[4] . '<br>';
}
?>
