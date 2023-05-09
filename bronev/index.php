<?php
// Подключение к базе данных SQLite3
$db = new SQLite3('bronev.db');

// Обработка отправленной формы
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $trip = $_POST['trip'];
    $date_time = $_POST['date_time'];
    $vehicle = $_POST['vehicle'];
    $free_seats = $_POST['free_seats'];
    $status = $_POST['status'];

    // Обновление данных в базе данных
    $query = "UPDATE trips SET trip='$trip', date_time='$date_time', vehicle='$vehicle', free_seats='$free_seats', status='$status' WHERE id='$id'";
    $db->query($query);
}

// Запрос на выборку данных из таблицы
$query = 'SELECT * FROM trips';
$results = $db->query($query);

// Вывод данных в виде HTML-таблицы и формы для редактирования
echo '<table border="1">';
echo '<tr><th>ID</th><th>Trip</th><th>Date/Time</th><th>Vehicle</th><th>Free Seats</th><th>Status</th><th>Actions</th></tr>';

while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    echo '<tr>';
    echo '<form method="post">';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td><input type="text" name="trip" value="' . $row['trip'] . '" style="width: 400px;"></td>';
    echo '<td><input type="text" name="date_time" value="' . $row['date_time'] . '"></td>';
    echo '<td><input type="text" name="vehicle" value="' . $row['vehicle'] . '"></td>';
    echo '<td><input type="text" name="free_seats" value="' . $row['free_seats'] . '"></td>';
    echo '<td><input type="text" name="status" value="' . $row['status'] . '"></td>';
    echo '<td><input type="hidden" name="id" value="' . $row['id'] . '"><input type="submit" name="submit" value="Save"></td>';
    echo '</form>';
    echo '</tr>';
}

echo '</table>';

// Закрытие соединения с базой данных
$db->close();
?>
