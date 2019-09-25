<?php
$conn = @new mysqli('localhost', 'jdyrcz', 'jdyrcz', 'jdyrcz');
if ($conn->connect_errno) die ('Brak połączenia');

header("Content-type: image/jpeg");

$rs = $conn -> query('SELECT id,nazwa,wart FROM tab_test')
  or die('Błąd pobierania danych');
  
$rysunek = imagecreate (1000, $rs -> num_rows * 50 + 20)
or die("Biblioteka graficzna nie została zainstalowana!");
$kolorbialy = imagecolorallocate ($rysunek, 255, 255, 255);
$kolorczarny = imagecolorallocate ($rysunek, 0, 0, 0);
imagefill($rysunek, 0, 0, $kolorbialy);
	
if ($rs -> num_rows > 0) {
	while ($rec = $rs->fetch_array()) {
    $kolorslupka = imagecolorallocate ($rysunek, $rec["wart"] * 2, 255 - $rec["wart"] * 2, 0);
    imagefilledrectangle ($rysunek, 60, $rec["id"] * 50 - 33, 60 + $rec["wart"] * 2, $rec["id"] * 50 - 3, $kolorslupka);
    imagestring ($rysunek, 5, 25, $rec["id"] * 50 - 23, $rec["nazwa"], $kolorczarny);
    imagestring ($rysunek, 5, 70 + $rec["wart"] * 2, $rec["id"] * 50 - 23, $rec["wart"], $kolorczarny);
	}
  imagejpeg($rysunek);
}
?>
