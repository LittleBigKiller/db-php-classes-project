<?php
	$los = [];
	for ($i = 0; $i < 30; $i++) {
		$los[$i] = rand(-20, 20);
		echo $los[$i].'<br>';
	}

    echo '<br>Powtórki: | ';
    $repeats = [];

    for ($i = 0; $i < count($los); $i++) {
        $tested = $los[$i];
        for ($j = 0; $j < count($los); $j++) {
            if ($i != $j)
                if ($los[$i] == $los[$j]) {
                    $uni = true;
                    foreach ($repeats as $temp)
                        if ($temp == $los[$j])
                            $uni = false;
                    if ($uni)
                        array_push($repeats, $los[$j]);
                }
        }
    }
    foreach ($repeats as $temp) {
        echo $temp.' | ';
    }
?>