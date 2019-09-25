<?php
	$los = [];
	for ($i = 0; $i < 20000; $i++) {
		$los[$i] = rand(-50, 50);
		echo $los[$i].'<br>';
	}

	$test = true;

	while ($test) {
		$test = false;
		for ($i = 0; $i < count($los) - 1; $i++) {
			if ($los[$i] > $los[$i + 1]) {
				$test = true;
				$temp = $los[$i];
				$los[$i] = $los[$i + 1];
				$los[$i + 1] = $temp;
			}
		}
	}
	echo 'Min: '.$los[0].'<br>';
	echo 'Max: '.$los[count($los) - 1];
?>