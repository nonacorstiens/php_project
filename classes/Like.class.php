<?php

class Like
{
    public static function checkLike($postId, $userId)
    {
        $conn = Db::getInstance();
        $stm = $conn->prepare('SELECT * from postLike where imageId = :postId AND userId = :userId');
        $stm->bindParam(':postId', $postId);
        $stm->bindParam(':userId', $userId);
        $stm->execute();

        $stm->fetchAll(PDO::FETCH_ASSOC);
        $count = $stm->rowCount();

        if ($count == 0) {
            if (Like::likePost($postId, $userId)) {
                return 'liked';
            } else {
                return 'likeFailed';
            }
        } else {
            if (Like::unlikePost($postId, $userId)) {
                return 'unliked';
            } else {
                return 'unlikeFailed';
            }
        }
    }

    public static function liked($postId, $userId)
    {
        $conn = Db::getInstance();
        $stm = $conn->prepare('SELECT * from postLike where imageId = :postId AND userId = :userId');
        $stm->bindParam(':postId', $postId);
        $stm->bindParam(':userId', $userId);
        $stm->execute();

        $stm->fetchAll(PDO::FETCH_ASSOC);
        $count = $stm->rowCount();
        if ($count == 0) {
            return 'no';
        } else {
            return 'yes';
        }
    }

    public static function likePost($postId, $userId)
    {
        $conn = Db::getInstance();
        $stm = $conn->prepare('INSERT INTO postLike (imageId, userId) values (:postId, :userId)');
        $stm->bindParam(':postId', $postId);
        $stm->bindParam(':userId', $userId);

        return $stm->execute();
    }

    public static function unlikePost($postId, $userId)
    {
        $conn = Db::getInstance();
        $stm = $conn->prepare('DELETE FROM postLike WHERE imageId = :postId AND userId =  :userId');
        $stm->bindParam(':postId', $postId);
        $stm->bindParam(':userId', $userId);

        return $stm->execute();
    }
}
