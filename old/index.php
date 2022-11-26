<?php
require "classes/Database.php";

$db = new Database;



$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if(isset($post['submit'])){
    $title = $post['title'];
    $body = $post['body'];

    $db->query("INSERT INTO posts (title, body) VALUES(:title, :body)");
    $db->bind(":title", $title);
    $db->bind(":body", $body);
    $db->execute();
    if($db->lastInsertId()) {
        echo "Post Added";
    }
}
$db->query("SELECT * FROM posts");
$rows = $db->resultSet();

?>
<title>PDO PROJ</title>
<h1>Posts</h1>
<form action="" method="post">
    <label>Post Title</label>
    <input type="text" name="title" placeholder="Add Title"/><br>
    <label>Body</label><br>
    <textarea name="body" id="" cols="30" rows="10"></textarea><br>
    <input type="submit" name="submit" value="Add New"/>
</form>
<div>
    <?php foreach ($rows as $row): ?>
        <div>
            <h3><?php echo $row['title']; ?></h3>
            <p><?php echo $row['body']; ?></p>
        </div>
    <?php endforeach;?>
</div>
