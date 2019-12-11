<?php
include('dbcredentials.php');
$conn = new mysqli($db_server, $db_user, $db_passwd, $db_dbname);

if ($conn->connect_errno) die('Brak połączenia');

$conn->query('SET NAMES utf8')
  or die('Nie udało się ustawić CHARSET');

header("Content-type: image/png");

$rs = $conn->query('SELECT `qid`, `contents` AS "question", `ans_correct` AS "correct", (`ans_total` - `ans_correct`) AS "incorrect", `ans_total` AS "total" FROM `questions` HAVING `ans_total` > 0 ORDER BY `ans_correct` / `ans_total` ASC LIMIT 10')
  or die('Błąd pobierania danych');



$rysunek = imagecreatetruecolor(520, 500)
  or die("Biblioteka graficzna nie została zainstalowana!");

putenv('GDFONTPATH=' . realpath('.'));

$font = 'Monospace.ttf';

imagesavealpha($rysunek, true);

$alpha = imagecolorallocatealpha($rysunek, 0, 0, 0, 127);
imagefill($rysunek, 0, 0, $alpha);

$kolorbialy = imagecolorallocate($rysunek, 255, 255, 255);
$kolorczarny = imagecolorallocate($rysunek, 0, 0, 0);
// imagefill($rysunek, 0, 0, $kolorbialy);

$counter = 0;
if ($rs->num_rows > 0) {
  while ($rec = $rs->fetch_array()) {
    $percentage = ($rec['total'] != 0 ? round($rec['correct'] / $rec['total'] * 100, 2) . '%' : '0%');
    // $percentage = '100%';

    $kolorslupka = imagecolorallocate($rysunek, 255 - $percentage * 2, $percentage * 2, 0);
    imagefilledrectangle($rysunek, 10, $counter * 50 + 10, 60 + $percentage * 4, $counter * 50 + 40, $kolorslupka);

    $q_len = $percentage / 2 - 1;

    $contents = (strlen($rec['question']) < $q_len ? $rec['question'] : substr($rec['question'], 0, $q_len - 3) . '...');
    imagettftext($rysunek, 12, 0, 15, $counter * 50 + 30, $kolorbialy, $font, $contents);
    // imagestring($rysunek,5, 15, $counter * 50 + 18, $contents, $kolorbialy);

    imagestring($rysunek, 5, 70 + $percentage * 4, $counter * 50 + 18, $percentage, $kolorbialy);

    $counter += 1;
  }
  imagepng($rysunek);
}
