<?php
include('dbcredentials.php');
$conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

if ($conn->connect_errno) die('Brak połączenia');

$conn->query('SET NAMES utf8')
  or die('Nie udało się ustawić CHARSET');

header("Content-type: image/png");

$rs = $conn->query('SELECT `users`.`username` AS "username", AVG(`results`.`ans_correct`) AS "avg" FROM `results` INNER JOIN `users` ON `results`.`uid` = `users`.`uid` GROUP BY `results`.`uid` ORDER BY AVG(`results`.`ans_correct`) DESC LIMIT 10')
  or die('Błąd pobierania danych');



$rysunek = imagecreatetruecolor(320, 500)
  or die("Biblioteka graficzna nie została zainstalowana!");

imagesavealpha($rysunek, true);

$alpha = imagecolorallocatealpha($rysunek, 0, 0, 0, 127);
imagefill($rysunek, 0, 0, $alpha);

$kolorbialy = imagecolorallocate($rysunek, 255, 255, 255);
$kolorczarny = imagecolorallocate($rysunek, 0, 0, 0);
// imagefill($rysunek, 0, 0, $kolorbialy);

$counter = 0;
if ($rs->num_rows > 0) {
  while ($rec = $rs->fetch_array()) {
    $percentage = (round($rec['avg'] * 10, 2) . '%');
    // $percentage = '100%';

    $kolorslupka = imagecolorallocate($rysunek, 255 - $percentage * 2, $percentage * 2, 0);
    imagefilledrectangle($rysunek, 10, $counter * 50 + 10, 60 + $percentage * 2, $counter * 50 + 40, $kolorslupka);

    $q_len = $percentage / 4;

    $contents = (strlen($rec['username']) < $q_len ? $rec['username'] : substr($rec['username'], 0, $q_len - 3) . '...');
    imagestring($rysunek, 5, 15, $counter * 50 + 18, $contents, $kolorbialy);

    imagestring($rysunek, 5, 70 + $percentage * 2, $counter * 50 + 18, $percentage, $kolorbialy);

    $counter += 1;
  }
  imagepng($rysunek);
}
