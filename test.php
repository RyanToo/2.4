<?php
session_start();

if (empty($_SESSION)) {
	header('Location: index.php');
	exit;
}

$dirTests = __DIR__ . '/json_tests';
$testList = glob("$dirTests/*.json");
$infoText = '';
$infoTextStyle = '';
$userAnswers = [];
$errorSum = 0;
$uncheckedRightSum = 0;
$testNumber = $_GET['test_number'];
krsort($testList);
$numLastTest = key($testList);

function submitUnset($var)
{
	if ($var == 'Проверить тест') {
		return false;
	}
	return true;
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Форма для прохождения теста</title>
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
	<?php
	if (isset($testNumber) && ($testNumber != NULL) && ($testNumber <= $numLastTest)) {
		$testArray = json_decode(file_get_contents($testList[$testNumber]), 1);
		$testTitle = $testArray['test_name'];
		$testQuestions = $testArray['questions'];
		$testSumPoints = $testArray['sum_points'];
	?>	
		<h1><?=$testTitle?></h1>

		<form method="POST" action="">
			<?php
			foreach ($testQuestions as $keyQuestion => $question) {
				$questionTitle = $question['question_title'];
				$inputType = $question['input_type'];
				$questionVariants = $question['variants'];
				$testRightAnswers = $question['answers'];
			?>
			<fieldset style="margin-top: 25px;">
				<legend><?=$questionTitle?></legend>
				<?php
				foreach ($questionVariants as $keyVariant => $variant) {
				?>
				<label>
					<input name="<?=$keyQuestion?>[]" value="<?=$variant?>" type="<?=$inputType?>">		
					<?=$variant?>
				</label>
				<?php
				}
				?>
			</fieldset>
			<?php 
				if (isset($_POST['check_test'])) {
					$userName = $_SESSION['user']['name'];
					if (isset($_POST[$keyQuestion])) {
						$userAnswers = array_filter($_POST, 'submitUnset');
						$errorCount = count(array_diff($testRightAnswers, $userAnswers[$keyQuestion])) + count(array_diff($userAnswers[$keyQuestion], $testRightAnswers));
						if ($errorCount == 0) {
							$errorCount = false;
						}
						$uncheckedRightAnswers = count(array_diff($testRightAnswers, $userAnswers[$keyQuestion]));
						if ($uncheckedRightAnswers == 0) {
								$uncheckedRightAnswers = false;
							}	
					}
					else {
						$errorCount = count($testRightAnswers);
						$uncheckedRightAnswers = count($testRightAnswers);
					}
					$errorSum = (is_numeric($errorCount)) ? $errorSum + $errorCount : $errorSum;
					$uncheckedRightSum = (is_numeric($uncheckedRightAnswers)) ? $uncheckedRightSum + $uncheckedRightAnswers : $uncheckedRightSum;

					if (!isset($_POST[$keyQuestion]) && $errorSum > 0) {
						$infoText = 'тест пройден, допущено ошибок: ' . $errorSum . ' шт.';
						$infoTextStyle = 'color: red';
					}
					if (isset($_POST['check_test']) && $errorSum == 0) {
						$infoText = 'тест пройден без ошибок';
						$infoTextStyle = 'color: green;';
					}
					elseif (isset($_POST['check_test']) && isset($_POST[$keyQuestion]) && $errorSum > 0) {
						$infoText = 'тест пройден, допущено ошибок: ' . $errorSum . ' шт.';
						$infoTextStyle = 'color: red';
					}
				}
				elseif (!isset($_POST['check_test']) && $errorSum == 0) {
					$infoText = 'для получения результата теста нужно ответить на вопросы';
					$infoTextStyle = '';
				}		
			}			
			?>
			<div style="margin-top: 20px">
				<input name="check_test" type="submit" value="Проверить тест">
			</div>
			<p style="<?=$infoTextStyle?>"><b>Результат теста:</b> <?=$infoText?></p>
		</form>
		<?php
		if (isset($_POST['check_test'])) {
			$testResult = $testSumPoints - ($uncheckedRightSum * 10);

			if(isset($userName) && ($userName != NULL) && isset($testResult)) {
			
		?>
		<div style="margin-top: 20px;">
			<a href="cert.php?user_name=<?=$userName?>&test_result=<?=$testResult?>&sum_points=<?=$testSumPoints?>" target="_blank">Получить сертификат о прохождении теста =></a>
		</div>
		<?php
			}
		}
		?>
		<div style="margin-top: 30px;">
			<a href="list.php"><= Вернуться к списку тестов</a>
		</div>
	<?php
	}
	/*else {
		http_response_code(404);
	}*/
	?>	
</body>
</html>