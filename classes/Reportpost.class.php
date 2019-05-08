<?php
class reportPost
{
    public static function uploadDB($imageId, $userId)
    {
        $conn = new PDO('mysql:host=localhost;dbname=PHPotato;charset=utf8mb4', 'root', 'root');
        $statement = $conn->prepare('INSERT INTO reportedPost(imageId, userId) values(:imageId, :userId)');
        $statement->bindParam(':imageId', $imageId);
        $statement->bindParam(':userId', $userId);
        $statement->execute();
    }

    public function setInappropriate($imageId, $userId)
    {
        $conn = new PDO('mysql:host=localhost;dbname=PHPotato;charset=utf8mb4', 'root', 'root');
        $statement = $conn->prepare('SELECT * from reportedPost where imageId = :imageId');
        $statement->bindParam(':imageId', $imageId);
        $result = $statement->execute();
        $reports = $statement->fetchAll(PDO::FETCH_ASSOC);
        $count = $statement->rowCount();
        try {
            if ($count == 0) {
                reportPost::uploadDB($imageId, $userId);
            } else {
                if ($count >= 2) {
                    Post::setInactive($imageId);
                } else {
                    foreach ($reports as $report) {
                        if ($report['userId'] == $userId) {
                        } else {
                            reportPost::uploadDB($imageId, $userId);
                        }
                    }
                }
            }
        } catch (Exception $e) {
        }
    }
}

?>

