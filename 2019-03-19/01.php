<?php
$conn = @new mysqli('localhost', 'jdyrcz', 'jdyrcz', 'jdyrcz');

if ($conn->connect_errno) die ('Brak połączenia');

$rs=$conn->query('SELECT nazwa,cena,ilosc FROM tab_0319')
	or die('Błąd pobierania danych');
	
if ($rs -> num_rows > 0) {
	echo '<table border=1><tr><th>Nazwa</th><th>Cena</th><th>Ilość</th></tr>';
	while ($rec = $rs->fetch_array()) {
		echo '<tr><td>'.$rec['nazwa'].'</td><td>'.$rec['cena'].'</td><td>'.$rec['ilosc'].'</td></tr>';
	}
	echo '</table>';
}
$rs->close();
$conn->close();
?>