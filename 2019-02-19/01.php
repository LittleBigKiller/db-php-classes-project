<?php
	for ($i = 0; $i < 10; $i++) {
		echo $i." obrót pętli for";
		echo "<br>";
	}
	
	echo "<br>";
	$i = 0;
	while ($i < 10) {
		echo $i." obrót pętli while";
		echo "<br>";
		$i++;
	}
	
	echo "<br>";
	$i = 0;
	do {
		echo $i." obrót pętli do while";
		echo "<br>";
		$i++;
	} while ($i < 10);

?>