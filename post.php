<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }
    $username=$_SESSION['username'];
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
<body>
    <nav>
        <item><a href="./index.php"><h2><?php echo $username ?></h2></a></item>
        <item><a href="./post.php">Add post</a></item>
        <item><a href="./logout.php">Logout</a></item>
    </nav>
    <main>
        <form action="post.php" method="post">
            <h3>Title:</h3>
            <textarea name="title" id="Textarea" rows="5"></textarea>
            <br>
            <h3>Description:</h3>
            <textarea name="descr" id="Textarea" rows="10"></textarea>
            <br>
            <br>
            <button type="submit">Add note</button>
            <?php
                if(isset($_POST['title']) && isset($_POST['descr']) && is_string($_POST['title']) && is_string($_POST['descr'])){
                    $title = $_POST['title'];
                    $descr = $_POST['descr'];
                    if(!preg_match("/^[a-zA-Z0-9_]+$/", $title, $matches) || strpos($descr, ':') || strpos($descr, ',')){
                        echo "<h4 class=\"error\">Invalid characters</h4>";
                    }else{
                        $db = new SQLite3('database.db');
                        $oldNotes = $db->query("SELECT notes FROM users WHERE username='$username'");
                        $row = $oldNotes->fetchArray();
                        if(strcmp('', $row[0])!=0){
                            $newNotes = $row[0].','.$title.':'.$descr;
                        }else{
                            $newNotes = $title.':'.$descr;
                        }
                        $db->query("UPDATE users SET notes='$newNotes' WHERE username='$username'");
                        $db->close();
                        header("Location: index.php");
                    }
                }
            ?>
        </form>
    </main>
</body>
</html>