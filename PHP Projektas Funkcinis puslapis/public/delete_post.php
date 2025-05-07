<?php
session_start();
require '../classes/Post.php';
require '../db/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: view_posts.php");
    exit();
}

$postId = $_GET['id'];
$post = new Post($db);
$success = $post->deletePost($postId, $_SESSION['user_id']);

if ($success) {
    $_SESSION['message'] = "Įrašas sėkmingai ištrintas.";
} else {
    $_SESSION['error'] = "Klaida trinant įrašą arba įrašas neegzistuoja.";
}

header("Location: view_posts.php");
exit();
?>