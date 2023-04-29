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
    <form action="login.php" method="post" class="container">
        <h1>Login</h1>
        <input type="text" name="username" placeholder="Username" required>
        <br><br>
        <input type="password" name="password" placeholder="Password" required>
        <br><br>
        <button type="submit">Sing in</button>
        <br><br>
        <a href="./register.php" class="init">Sign up</a>
        <?php
            if(isset($_POST['username']) && isset($_POST['password']) && is_string($_POST['username']) && is_string($_POST['password'])){
                $username = $_POST['username'];
                $password = $_POST['password'];
                if(!preg_match("/^[a-zA-Z0-9_]+$/", $username, $matches) || !preg_match("/^[a-zA-Z0-9_]+$/", $password, $matches)){
                    echo "<h4 class=\"error\">Invalid username/password</h4>";
                    die();
                };
                $db = new SQLite3('database.db');
                $result = $db->query("SELECT username, password FROM users WHERE username='$username'");
                $row = $result->fetchArray();
                $db->close();
                if($row && strcmp($password, $row[1])==0){
                    $_SESSION['username'] = $row['username'];
                    header('Location: index.php');
                    exit;
                } else {
                    echo "<h4 class=\"error\">Incorrect username/password</h4>";
                }
            }
        ?>
    </form>
</body>
</html>