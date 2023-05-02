    <?php
		include('..\admin\update_def.php');
		// Имя файла базы данных
		$db_file = '..\admin\mydatabase.db';

		// Создаем объект базы данных SQLite3
		$db = new SQLite3($db_file);

		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]".".html";

        
	
		function monthToNumber($day, $month) {
			if ($month == "апр"){
				return $day.".04";
			}
			if ($month == "мая"){
				return $day.".05";
			}
		}

		// HTTP заголовки для указания, что мы получаем HTML страницу
		//header('Content-Type: text/html; charset=utf-8');

		// Создание и загрузка DOM документа
		$html = new DOMDocument();
		$html->loadHTMLFile($actual_link);

		// Создание объекта XPath
		$xpath = new DOMXpath($html);

		// XPath выражение для нахождения span элемента на странице
		$span_xpath = "/html/body/section[1]/div[1]/div[2]/div[2]/div[1]/div/div[1]/span[1]";

		// Получение span элемента
		$span = $xpath->query($span_xpath)->item(0);

		// Получение содержимого span элемента
		$text_date = $span->textContent;


		// XPath выражение для нахождения span элемента на странице
		$span_xpath = "/html/body/section[1]/div[1]/div[2]/div[2]/div[1]/div/div[1]/span[2]";

		// Получение span элемента
		$span = $xpath->query($span_xpath)->item(0);

		// Получение содержимого span элемента
		$text_mo = $span->textContent;

        // XPath выражение для нахождения span элемента на странице
		$span_xpath = "/html/body/section[1]/div[1]/div[2]/div[1]/div/div/h1";

		// Получение span элемента
		$span = $xpath->query($span_xpath)->item(0);

		// Получение содержимого span элемента
		$trip = $span->textContent;

		$date_text = monthToNumber($text_date, $text_mo); // выводит "29.04"
        

		// Выполняем запрос на выборку данных из таблицы trips
		$result = $db->query('SELECT free_seats FROM trips WHERE trip = "'.$trip.'" AND date_time LIKE "'.$date_text.'%"');

		// Создаем массив для хранения данных
		$data = array();

		// Получаем данные из результата запроса и добавляем их в массив
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$data[] = $row['free_seats'];
		}

        if (empty($data[0])){
            echo "10 мест";
        } else {
            echo $data[0] . " мест";
        }
		

		// Закрываем соединение с базой данных
		$db->close();
	?>