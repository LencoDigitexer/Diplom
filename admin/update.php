<?php
// Проверяем, была ли нажата кнопка "Обновить данные"
if(isset($_POST['update'])) {
    // Имя файла базы данных
    $db_file = 'mydatabase.db';

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

    // Создаем объект базы данных SQLite3
    $db = new SQLite3($db_file);

    // Создаем таблицу, если она не существует
    $db->exec('CREATE TABLE IF NOT EXISTS trips (id INTEGER PRIMARY KEY AUTOINCREMENT, trip TEXT, date_time TEXT, vehicle TEXT, free_seats INTEGER, status TEXT)');


    // Выводим данные на экран
    foreach ($data as $row) {
        echo "trip_from " . $row[0] . " date_time " .  $row[1] . " vehicle " . $row[2] . " free_seats " . $row[3] . " status " . $row[4] . '<br>';

    

        // Проверяем, есть ли уже такие данные в таблице
        $trip = $row[0];
        $date_time = $row[1];
        $vehicle = trim($row[2]);
        $free_seats = $row[3];
        $status = trim($row[4]);

        $result = $db->query("SELECT * FROM trips WHERE trip='$trip' AND date_time='$date_time' AND vehicle='$vehicle'");

        if($result->fetchArray(SQLITE3_ASSOC)) {
            // Если данные уже существуют, выводим сообщение об ошибке
            $db->exec("UPDATE trips SET free_seats=$free_seats WHERE trip='$trip' AND date_time='$date_time' AND vehicle='$vehicle'");
            echo "Данные уже существуют в базе данных!";
        } else {
            // Если данных нет в таблице, добавляем их
            $db->exec("INSERT INTO trips (trip, date_time, vehicle, free_seats, status) VALUES ('$trip', '$date_time', '$vehicle', $free_seats, '$status')");

            // Выводим сообщение об успешном добавлении данных
            echo "Данные успешно добавлены в базу данных!";
        }

    }

    // Закрываем соединение с базой данных
    $db->close();
}
?>
