<?php
		include('..\admin\update_def.php');

        echo "Тур " . $_GET['tour'] . "<br>";

        $tour = (string)$_GET['tour'];

		// Имя файла базы данных
		$db_file = '..\admin\mydatabase.db';

		// Создаем объект базы данных SQLite3
		$db = new SQLite3($db_file);

		// Выполняем запрос на выборку данных из таблицы trips
		$result = $db->query('SELECT free_seats FROM trips WHERE trip = "'.$_GET['tour'].'"');

		// Создаем массив для хранения данных
		$data = array();

		// Получаем данные из результата запроса и добавляем их в массив
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$data[] = $row['free_seats'];
		}

		// Закрываем соединение с базой данных
		$db->close();


        if(empty($data[0])) { 
            echo "нет данеых"; 
            } else { 
            echo $data[0] . " мест"; 
            }
	?>