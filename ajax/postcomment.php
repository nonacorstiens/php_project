<?php

require_once '../bootstrap.php';

session_start();

if (!empty($_POST)) {
    // comment tekst uitlezen
        $text = $_POST['text']; // komt uit ajax injectie data{text: text} --> de eerste
        // comment opslaan in databank
        try {
            $comment = new Comment();
            $comment->setDescription($text);
            $comment->setUserId($_SESSION['userid']);
            $comment->setImageId($_POST['id']);
            $comment->uploadComment();

            $result = [
                'status' => 'success',
                'message' => 'Comment saved',
            ];
        } catch (Throwable $t) { // throwable zijn alle mogelijke exceptions die kunnen gebeuren
            $result = [
                'status' => 'error',
                'message' => 'something went wrong',
            ];
        }

    echo json_encode($result);
}
