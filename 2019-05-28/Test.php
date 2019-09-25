<?php
$conn = @new mysqli('localhost', 'jdyrcz', 'jdyrcz', 'jdyrcz');
if ($conn->connect_errno) die ('Brak połączenia');

if (isset($_GET['akcja'])) {
	if ($_GET['akcja'] == 'Dodaj') {
        if (isset($_GET['opcja'])) {
            $conn->query("UPDATE tab_test SET wart = wart + 1 WHERE id=".$_GET['opcja']);
        }
    }
}

$rs = $conn -> query('SELECT id,nazwa,wart FROM tab_test')
	or die('Błąd pobierania danych');
	
if ($rs -> num_rows > 0) {
	echo '<form><h3>Wybierz jeden:</h3>';
	while ($rec = $rs->fetch_array()) {
        echo '<input type="radio" value="'.$rec["id"].'" name="opcja"><label>'.$rec["nazwa"].' - '.$rec["wart"].'</label><br>';
	}
	echo '<input type="submit" name="akcja" value="Dodaj"></form>';
}

echo '<img src="/www/jdyrcz/2019-05-28/Wykres.php">'
?>