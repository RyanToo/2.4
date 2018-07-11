<?php
session_start();

if (empty($_SESSION)) {
	header('Location: index.php');
	exit;
}

$dirTests = __DIR__ . '/json_tests';
$testList = glob("$dirTests/*.json");

if (isset($_POST['clear_tests']) && !empty($testList)){
	foreach ($testList as $testLink) {
		unlink($testLink);
		unset($testList);
	}
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Список загруженных тестов</title>

	<style>
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
	<h1>Список загруженных  тестов</h1>
	<?php
	if (!empty($testList)) {
		echo '<ul>';
			foreach ($testList as $key => $test) {
	    		$testInfo = json_decode(file_get_contents($test), 1);
	    		$testName = $testInfo['test_name'];
	    		echo "<li><a href=\"test.php?test_number=$key\">" . $testName . "</a></li>";
			}
			
		echo '</ul>';
	}
	else {
		echo '<p>На сервере нет ни одного теста, перейдите к загрузке тестов</p>';
	}
	if ($_SESSION['user']['role'] === 'admin') {
	?>
    <div style="margin-top: 20px">
        <a href="admin.php"><= Загрузить новый тест</a>
      </div>
      <?php
	 }

	 if (!empty($testList) && $_SESSION['user']['role'] === 'admin') {
     ?>
     <form action="" method="post" style="margin: 20px 0 0 10px">
    	 <input name="clear_tests" type="submit" value="Удалить все тесты">
      </form>
    <?php
	}
    ?>
</body>
</html>