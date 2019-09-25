<?php
	$suma = 0;
	$i = 1;
	$powt = 0;
	
	while (($suma + $i) < 100) {
		$suma += $i;
		$i++;
		$powt++;
	}
	echo 'Ilość: '.$powt.'<br>';
	echo 'Suma: '.$suma
?>