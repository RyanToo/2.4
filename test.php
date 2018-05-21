<?php 

if (file_exists($_GET['testname'])) {
	$a = $_GET['testname'];
   $file = file_get_contents($a);
   $fileDecode = json_decode($file, true); 

}else{
	
	http_response_code(404);
    echo "Not found";
    die();
}     
?>

<html>
<head>
	<meta charset="UTF-8">
	<title>Задачи</title>
</head>
<body>
	<p>Решите задачу:</p>
<form action="result.php" method="POST">
	
		<?php foreach ($fileDecode as  $value) { ?>
		
		<fieldset>

		<legend><?= $label = $value['question'] ?></legend>
				
				<?php foreach ($value['input'] as $key => $k) { ?>
					<input type="radio" name="<?php echo $k['name']?>" value="<?php echo $k['value']?>">
				<?= $k['answer'] ?>
				<?php } ?>	
		</fieldset>	
		<?php }?>
		<p>Введите ваше имя</p>
		<input type="text" name="name">
		<input type="submit" value="Получить сертификат о прохождении">
</form>

	
</body>
</html>
