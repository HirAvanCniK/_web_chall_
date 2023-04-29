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
        <item><a href="./index.php"><h2><?php if(strcmp('admin', $username)==0) echo file_get_contents("flag.txt"); else echo $username ?></h2></a></item>
        <item><a href="./post.php">Add post</a></item>
        <item><a href="./logout.php">Logout</a></item>
    </nav>
    <main>
        <?php
            $db = new SQLite3('database.db');
            $notes = $db->query("SELECT notes FROM users WHERE username='$username'");
            $row = $notes->fetchArray();
            $posts = $row[0];
            if(strcmp('', $posts)==0){
                echo "<h3>No posts yet</h3>";
            }else{
                echo "<table class=\"post_table\">";
                echo "<tr><td class=\"column_title\">Title</td><td class=\"column_title\">Description</td></tr>";
                foreach(explode(',', $posts) as $post){
                    $title = explode(':', $post)[0];
                    $desc = explode(':', $post)[1];
                    if(!strstr($desc, "flag")){
                        echo "<tr><td class=\"table_data\">$title</td><td class=\"table_data\">$desc</td></tr>";
                    }
                }
                echo "</table>";
            }
        ?>
    </main>
</body>
</html>