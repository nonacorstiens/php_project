<?php
    require_once '../bootstrap.php';

    if (!empty($_POST)) {
        // comment tekst uitlezen
        $comment = $_POST['comment']; // komt uit ajax injectie data{text: text} --> de eerste
        var_dump($comment);
        // comment opslaan in databank
        try {
            $comment = new \php_project\Comment();
            $comment->setUserId($_SESSION['userid']);
            $comment->setDescription($comment);
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
