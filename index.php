<?php
session_start();
$authError = '';
$style = '';

if (!empty($_POST)) {
    $dirUsers = __DIR__ . '/user/users.json';
    $usersArray = json_decode(file_get_contents($dirUsers), 1);

    foreach ($usersArray as $user) {
        if ($_POST['login'] === $user['login'] && $_POST['password'] === $user['password']) {
            $_SESSION['user'] = $user;
            header('Location: list.php');
            exit;
        }
        elseif (!empty($_POST['login']) && $_POST['login'] !== $user['login']) {
            $_SESSION['user']['name'] = $_POST['login'];
            $_SESSION['user']['role'] = 'user';
            header('Location: list.php');
            exit;
        }
    }

    $authError = 'Неправильный логин или пароль';
    $style = 'color: red';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель авторизации пользователя</title>

    <style>
        form {
            display: inline-block;
        }
        label {
            display: block;
            margin: 15px 0;
        }
        h1 {
            text-align: center;
        }
        .auth-form {
            width: 50%;
            margin: 0 auto;
        }
    </style>
</head>
<body style=" color: blue;" >
    <h1>Панель авторизации пользователя</h1>
    <?php
    if (empty($_SESSION)) {
    ?>
    <div class="auth-form">
        <p>Для прохождения теста вам необходимо вставить имя Login, если нужно загрузить/удалить тесты, то необходимо авторизоваться под Администратором
        </p>

        <form action="" method="post">
            <label>
                Логин
                <input name="login" type="text">
            </label>
            <label>
                Пароль
                <input name="password" type="password">
            </label>
            <input name="auth_submit" type="submit" value="Войти">
        </form>
        <p style="<?=$style?>"><?=$authError?></p>
    </div>
    <?php
    }
    else {
    ?>
    <h3 style="text-align: center;">Вы уже авторизованны</h3>
    <a href="list.php" style="text-align: center; display: block; margin-bottom: 20px">Перейти к тестам =></a>
    <a href="logout.php" style="text-align: center; display: block">Выйти</a>
    <?php
    }
    ?>   
</body>
</html>