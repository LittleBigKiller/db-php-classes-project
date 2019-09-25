<?php
$conn = @new mysqli('localhost', 'jdyrcz', 'jdyrcz', 'jdyrcz');

if ($conn->connect_errno) die ('Brak połączenia');

if (isset($_GET['akcja'])) {
	switch ($_GET['akcja']) {
        case 'Dodaj':
            $nazwa = $_GET["nazwa"];
            $cena = $_GET["cena"];
            $ilosc = $_GET["ilosc"];
			$conn -> query("INSERT INTO tab_0319(nazwa, cena, ilosc)
			VALUES ('$nazwa', $cena, $ilosc)") or die('INSERT nie działa');
			break;
	}
}

$rs = $conn -> query('SELECT nazwa,cena,ilosc FROM tab_0319')
	or die('Błąd pobierania danych');
	
if ($rs -> num_rows > 0) {
	echo '<table border=1><tr><th>Nazwa</th><th>Cena</th><th>Ilość</th><th>Usuwanie</th><th>Edycja</th></tr>';
	while ($rec = $rs->fetch_array()) {
        echo '<form><input type="hidden" name="id" value=""><tr><td>'.$rec['nazwa'].'</td>
        <td>'.$rec['cena'].'</td>
        <td>'.$rec['ilosc'].'</td>
        <td><input type="submit" name="akcja" value="Usuń"></td>
        <td><input type="submit" name="akcja" value="Edytuj"></td>
        </tr></form>';
	}
	echo '</table>';
}
$rs->close();
$conn->close();
?>
<form>
Nazwa Produktu: <input type="tekst" name="nazwa"><br>
Cena: <input type="tekst" name="cena"><br>
Ilość: <input type="tekst" name="ilosc"><br>
<input type="submit" name="akcja" value="Dodaj">
</form>
