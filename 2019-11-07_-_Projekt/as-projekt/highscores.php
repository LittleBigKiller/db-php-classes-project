<?php
include('dbcredentials.php');
$conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

if ($conn->connect_errno) die('Brak połączenia');

$rs = $conn->query('SELECT `users`.`username` AS "username", AVG(`results`.`ans_correct`) AS "avg" FROM `results` INNER JOIN `users` ON `results`.`uid` = `users`.`uid` GROUP BY `results`.`uid` ORDER BY AVG(`results`.`ans_correct`) DESC LIMIT 10')
    or die('Błąd pobierania danych');

if ($rs->num_rows > 0) {
    echo '<table border=1>
		<tr><th>Użytkownik</th><th>Średnia Ocen</th></tr>';
    while ($rec = $rs->fetch_array()) {
        echo "<tr>
			<td>" . $rec["username"] . "</td>
			<td>" . ($rec["avg"] * 10) . "%</td>
			</tr>";
    }
} else {
    echo 'no data';
}

?>