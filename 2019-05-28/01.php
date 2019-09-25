<?php
$conn = @new mysqli('localhost', 'jdyrcz', 'jdyrcz', 'jdyrcz');

if ($conn->connect_errno) die ('Brak połączenia');

$nazwa = '';
$cena = '';
$ilosc = '';
$id = '';
$przycisk = 'Dodaj';

if (isset($_GET['akcja'])) {
	switch ($_GET['akcja']) {
        case 'Dodaj':
                $nazwa = $_GET["nazwa"];
                $cena = $_GET["cena"];
                $ilosc = $_GET["ilosc"];
	        $conn -> query("INSERT INTO tab_0319(nazwa, cena, ilosc)
                VALUES ('$nazwa', $cena, $ilosc)") or die('Błędne dane');
                break;
        case 'Usuń':
                $conn -> query("DELETE FROM tab_0319 WHERE id=".$_GET['id']);
                break;
        case 'Edytuj':
                $rs=$conn->query("SELECT nazwa,cena,ilosc FROM tab_0319 WHERE id=".$_GET['id']);
                if($rs->num_rows>0)
                {
                        $rec=$rs->fetch_array();
                        $nazwa=$rec['nazwa'];
                        $cena=$rec['cena'];
                        $ilosc=$rec['ilosc'];
                        $id=$_GET['id'];
                        $przycisk='Zapisz';
                }
                break;	
        case 'Zapisz':
                $nazwa=$_GET['nazwa'];
                $cena=$_GET['cena'];
                $ilosc=$_GET['ilosc'];
                $conn->query("UPDATE tab_0319 SET nazwa='$nazwa',cena=$cena,
                ilosc=$ilosc WHERE id=".$_GET['id']);
                $nazwa='';
                $cena='';
                $ilosc='';
                break;
        }
}

$rs = $conn -> query('SELECT id,nazwa,cena,ilosc FROM tab_0319')
	or die('Błąd pobierania danych');
	
if ($rs -> num_rows > 0) {
	echo '<table border=1><tr><th>Nazwa</th><th>Cena</th><th>Ilość</th><th>Usuwanie</th><th>Edycja</th></tr>';
	while ($rec = $rs->fetch_array()) {
        echo "<form><input type='hidden' name='id' value='".$rec["id"]."'><tr><td>".$rec["nazwa"]."</td>
        <td>".$rec["cena"]."</td>
        <td>".$rec["ilosc"]."</td>
        <td><input type='submit' name='akcja' value='Usuń'></td>
        <td><input type='submit' name='akcja' value='Edytuj'></td>
        </tr></form>";
	}
	echo '</table>';
}
$rs->close();
$conn->close();

echo '
<h3>Wybierz jeden:</h3>
<form>
<input type="hidden" name="id" value="'.$id.'">
Nazwa Produktu: <input type="tekst" name="nazwa" value="'.$nazwa.'"><br>
Cena: <input type="tekst" name="cena" value="'.$cena.'"><br>
Ilość: <input type="tekst" name="ilosc" value="'.$ilosc.'"><br>
<input type="submit" name="akcja"  value="'.$przycisk.'">
</form>
';
?>
