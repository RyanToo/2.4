<?php
session_start();

if (empty($_SESSION)) {
	header('Location: index.php');
	exit;
}

if ($_SESSION['user']['role'] === 'admin') {
	$infoStyle = '';
	$infoText = '';
	$dirTests = __DIR__ . '/json_tests';
	$testList = glob("$dirTests/*.json");
	$testCount = count($testList);
	$testCorrectKeys = ['test_name', 'sum_points', 'questions'];
	$host = $_SERVER['HTTP_HOST'];
	$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$listFileName = 'list.php';

	if (isset($_FILES['test_file']) && !empty($_FILES['test_file']['name'])) {
		$file = $_FILES['test_file'];
		$fileName = ($testCount + 1) . '.json';
		$testArray = json_decode(file_get_contents($file['tmp_name']), 1);
		$testArrayKeys = array_keys($testArray);

		if ($file['type'] !== 'application/json') {
			$infoStyle = 'color: red';
			$infoText = 'Файл не загружен, т.к. он не имеет формат JSON';
		}
		elseif ($file['size'] > 2900000) {
			$infoStyle = 'color: red';
			$infoText = 'Файл не загружен, превышен максимальный размер в 2,9 МБ';
		}
		elseif ($testArrayKeys !== $testCorrectKeys) {
			$infoStyle = 'color: red';
			$infoText = 'Файл не загружен, т.к. имеет не правильную структуру';
		}
		elseif ($file['error'] !== UPLOAD_ERR_OK) {
			$infoStyle = 'color: red';
			$infoText = 'Произошла ошибка загрузки файла, попробуйте еще раз';
		}
		elseif (move_uploaded_file($file['tmp_name'], __DIR__ . "/json_tests/$fileName")) {
			header("Location: http://$host$uri/$listFileName");
			exit;
			$infoStyle = 'color: green';
			$infoText = 'Файл успешно загружен';
		}
	}	
	?>

	<!DOCTYPE html>
	<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<title>Модуль загрузки тестов</title>

		<style>
			form {
				display: inline-block;
			}
			header {
				padding: 5px 45px;
				border-bottom: 1px solid #999999;
				background-color: #f4f5f6;
			}
			.hello-text {
				float: left;
			}
			.logout-link {
				float: right;
				padding: 18px 0;
			}
			.clearfix:after {
				content: "";
				width: 100%;
				display: block;
				clear: both;
			}
		</style>
	</head>
	<body>
		<header class="clearfix">
			<div class="hello-text">
				<h3>Здравствуйте, <?=$_SESSION['user']['name']?></h3>
			</div>
			<div class="logout-link">
				<a href="logout.php">Выйти</a>
			</div>
		</header>
		<h1>Модуль загрузки тестов</h1>
		<p>Файл примера теста для загрузки в формате JSON: <a href="./json_example/test2.json" download="">тест</a></p>
		<form method="POST" action="" enctype="multipart/form-data">
			<fieldset>
				<legend>Форма загрузки файлов</legend>
				<label>
					Файл:
					<input name="test_file" type="file">
				</label>
				<div style="margin-top: 40px">
					<input name="load_file" type="submit" value="Загрузить файл">
				</div>
				<p style="<?=$infoStyle?>"><?=$infoText?></p>
			</fieldset>
		</form>
		<div style="margin-top: 60px">
			<a href="list.php">Перейти к списку тестов =></a>
		</div>
	</body>
	</html>
<?php
}
else {
	http_response_code(403);
	echo '<h1 style="text-align: center; color: red;">Доступ к загрузке тестов запрещен!</h1>';
	echo '<p style="text-align: center;"><a href="list.php">Перейти к списку тестов =></a></p>';
}