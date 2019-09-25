<?php
  for($i=0; $i<10; $i++)
    { $liczby[$i] = rand() % 10; }
  header("Content-type: image/jpeg");
  $rysunek = imagecreate (550, 500)
    or die("Biblioteka graficzna nie została zainstalowana!");
  $kolorbialy = imagecolorallocate ($rysunek, 255, 255, 255);
  $kolorczarny = imagecolorallocate ($rysunek, 0, 0, 0);
  imagefill($rysunek, 0, 0, $kolorbialy);

  for( $i=0; $i<10; $i++)
  {
    $kolorslupka = imagecolorallocate ($rysunek, 25 * $i, 255 - 25*$i, 0);
    imagefilledrectangle ($rysunek, 60, 13 + $i * 50, 60 + $liczby[$i] * 50, $i * 50 + 37, $kolorslupka);
    imagestring ($rysunek, 25, 25, 15 + $i * 50, $liczby[$i], $kolorczarny);
  }
  imagejpeg($rysunek);
?>
