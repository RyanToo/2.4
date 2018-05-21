<?php
require_once 'functions.php';



if (checkAuthorizate()) {
	
    foreach (getUsers() as $user){
    	if($_POST['guest']){
    		$_SESSION['guest'] = $_POST['guest'];
    		redirect('list');
    	}elseif ($_POST['login'] == $user['login'] && $_POST['password'] == $user['password']) {
    		$_SESSION['user'] = $user;
    	    redirect('list');
        }
    }
}

?>


<html>
<head>
	<meta charset="UTF-8">
	<title>Тест</title>
</head>
<body>

	<fieldset>
		<legend>Авторизация</legend>
	<form method="POST" action="">

		<label><input type="text" name="login" placeholder="Логин"></label>
		<br />
		<label><input type="password" name="password" placeholder="Пароль"></label>
		
		
		<p>Войти как гость:</p>
		<hr />
		<input type="text" name="guest" placeholder="Введите ваше имя"> 
		

		
       	        


		
<p><input type="submit" value="">отправить</p>

	</form>
	</fieldset>
</body>
</html>
