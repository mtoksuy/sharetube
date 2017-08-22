<?php
	function factorial($num = 0) {
		$num=(int)$num;
		$i  =(int)$num;
		while($num>1) {
			$num--;
			$i=$i*$num;
		}
		return $i;
	}
	$i = factorial(4); // 24
	echo $i;

	function factorial_2($num = 0) {
		$num=(int)$num;
		if($num==0) {
			return 1;
		}
			else {
				return $num * factorial_2($num-1);
			}
	}
	$i = factorial_2(4); // 24
?>
