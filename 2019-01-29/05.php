<?php
	define("BR","<br>");
	$tekst = '12';
	$liczba = 12;
	
	echo $liczba + $tekst;
	echo BR;
	echo $liczba.$tekst;
	echo BR;
	$tekst.=12;
	echo $tekst;
	echo BR;
	echo $tekst++;
	echo BR;
	echo ++$tekst;
?>