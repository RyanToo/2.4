<?php
session_start();
if (empty($_SESSION)) {
	header('Location: index.php');
	exit;
}

$header = 'Сертификат';
$labelName = 'Выдан на имя:';
$labelResult = 'Оценка в баллах:';
$labelSumPoints = 'из';
$userName = $_GET['user_name'];
$testResult = $_GET['test_result'];
$sumPoints = $_GET['sum_points'];

	$image = imagecreatetruecolor(566, 800);
	$backColor = imagecolorallocate($image, 245, 245, 245);
	$redColor = imagecolorallocate($image, 255, 0, 0);
	$blackColor = imagecolorallocate($image, 0, 0, 0);
	$blueColor = imagecolorallocate($image, 0, 101, 189);
$certFile = __DIR__ . '/img/cert.png';
if (!file_exists($certFile)) {
	echo 'Файл с изображением не найден';
	exit;
}
$certImg = imagecreatefrompng($certFile);
imagefill($image, 0, 0, $backColor);
imagecopy($image, $certImg, 0, 0, 0, 0, 566, 800);

	$fontFile = __DIR__ . '/font/comic-sans-ms-bold.ttf';
	if (!file_exists($fontFile)) {
		echo 'Файл со шрифтом не найден';
		exit;
	}
imagettftext($image, 46, 0, 110, 250, $redColor, $fontFile, $header);
imagettftext($image, 24, 0, 40, 330, $blackColor, $fontFile, $labelName);
imagettftext($image, 24, 0, 285, 330, $blueColor, $fontFile, $userName);
imagettftext($image, 24, 0, 40, 480, $blackColor, $fontFile, $labelResult);
imagettftext($image, 24, 0, 340, 480, $blueColor, $fontFile, $testResult);
imagettftext($image, 24, 0, 390, 480, $blackColor, $fontFile, $labelSumPoints);
imagettftext($image, 24, 0, 440, 480, $blueColor, $fontFile, $sumPoints);
header('Content-Type: image/png');
imagepng($image);
?>