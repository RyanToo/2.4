<?php 
define('RIGHT_ANSWER', 'tr');

$ot = 0;

if ($_POST['a1'] == RIGHT_ANSWER){
	$ot++;
}
 

if ($_POST['a2'] == RIGHT_ANSWER){
	$ot++;
}


if ($_POST['a3'] == RIGHT_ANSWER){
	$ot++;
}
	
		$name = $_POST['name'];
		$im =  imagecreatefrompng('img/sert.png');

			$color = imagecolorallocate($im, 0,0,0);

			$font = __DIR__.'/times.ttf';
			imagettftext($im, 40, 0, 400, 270, $color, $font, $name);
			imagettftext($im, 40, 0, 480, 520, $color, $font, $ot);
			header("Content-type: image/png");
			imagepng($im);
			imagedestroy($im);
			?>
	 
