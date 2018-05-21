<?php
 $uploaddir = 'tests/';
 $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
  if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
	header('Location: list.php');
	 exit();
}
?>

<html>
<head>
	<meta charset="UTF-8">
	<title>Задача</title>
</head>
<body>
	<form enctype="multipart/form-data" action="admin.php" method="POST">
		  <input type="file" name="userfile">
		  <input type="submit" value="Отправить">
	</form>
</body>
</html>

