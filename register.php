<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Notes</title>
</head>
<body class="init">
    <form action="register.php" method="post" class="container">
        <h1>Register</h1>
        <input type="text" name="username" placeholder="Username" required>
        <br><br>
        <input type="password" name="password" placeholder="Password" required>
        <br><br>
        <input type="password" name="re-password" placeholder="Re-Password" required>
        <br><br>
        <button type="submit">Sing up</button>
        <br><br>
        <a href="./login.php" class="init">Sign in</a>
        <?php
            if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['re-password']) && is_string($_POST['username']) && is_string($_POST['password']) && is_string($_POST['re-password'])){
                $username = $_POST['username'];
                $password = $_POST['password'];
                $re_password = $_POST['re-password'];
                if(!preg_match("/^[a-zA-Z0-9_]+$/", $username, $matches) || !preg_match("/^[a-zA-Z0-9_]+$/", $password, $matches) || !preg_match("/^[a-zA-Z0-9_]+$/", $re_password, $matches)){
                    echo "<h4 class=\"error\">Invalid username/password</h4>";
                    die();
                };
                if(strcmp($password, $re_password)!=0){
                    echo "<h4 class=\"error\">Passwords are different</h4>";
                    die();
                }
                $db = new SQLite3('database.db');
                $result = $db->query("SELECT username FROM users WHERE username='$username'");
                $row = $result->fetchArray();
                if(strcmp($row[0], $username)==0){
                    echo "<h4 class=\"error\">Username already exists</h4>";
                }else{
                    $db->query("INSERT INTO users (username, password, notes) VALUES ('$username', '$password', '')");
                    $db->close();
                    header('Location: login.php');
                }
                $db->close();
            }
        ?>
    </form>
</body>
</html>