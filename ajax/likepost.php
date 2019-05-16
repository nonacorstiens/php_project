<?php

require_once '../bootstrap.php';

session_start();

$postId = $_POST['postId'];
$userId = $_SESSION['userid'];
$post = new Like();
        $boolean = $post->checkLike($postId, $userId);

if ($boolean == 'liked') {
    $res = [
        'status' => 'like',
        'message' => 'You liked this post',
    ];
} elseif ($boolean == 'unliked') {
    $res = [
        'status' => 'unlike',
        'message' => 'You unliked this post',
    ];
} elseif ($boolean == 'likeFailed') {
    $res = [
        'status' => 'failed',
        'message' => 'like failed',
    ];
} elseif ($boolean == 'unlikeFailed') {
    $res = [
        'status' => 'failed',
        'message' => 'unlike failed',
    ];
} else {
    $res = [
        'status' => 'failed',
        'message' => 'something else went wrong',
    ];
}

echo json_encode($res);
