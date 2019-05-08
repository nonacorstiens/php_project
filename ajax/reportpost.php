<?php

require_once '../bootstrap.php';

session_start();

if (isset($_POST)) {
    $imageId = $_POST['imageId'];
    $userId = $_SESSION['userid'];
    try {
        $report = new reportPost();
        $report->setInappropriate($imageId, $userId);

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
