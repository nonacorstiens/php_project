<?php

require_once '../bootstrap.php';

session_start();

if (isset($_POST)) {
    $imageId = $_POST['imageId'];
    $userId = $_SESSION['userid'];
    try {
        $post = new Post();
        $boolean = $post->setInappropriate($imageId, $userId);

        if ($boolean == 'ok') {
            $result = [
                'status' => 'success',
                'message' => 'You marked this post as inappropriate',
            ];
        } elseif ($boolean == 'deleted') {
            $result = [
                'status' => 'delete',
                'message' => 'This post will be deleted because it was marked as inappropriate by 3 users',
            ];
        } else {
            $result = [
                'status' => 'fail',
                'message' => 'You have already marked this post',
            ];
        }
    } catch (Throwable $t) { // throwable zijn alle mogelijke exceptions die kunnen gebeuren
        $result = [
                'status' => 'error',
                'message' => 'something went wrong',
            ];
    }
    echo json_encode($result);
}
