<?php

class Comment
{
    private $description;
    private $userId;
    private $imageId;

    /**
     * Get the value of description.
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description.
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of userId.
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId.
     *
     * @return self
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of imageId.
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * Set the value of imageId.
     *
     * @return self
     */
    public function setImageId($imageId)
    {
        $this->imageId = $imageId;

        return $this;
    }

    public static function getAll($id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare('select * from postComment where imageId = :id order by id asc');
        $statement->bindParam(':id', $id);
        $result = $statement->execute();

        // fetch all records from the database and return them as objects of this __CLASS__ (Post)
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function uploadComment()
    {
        $conn = new PDO('mysql:host=localhost;dbname=PHPotato;charset=utf8mb4', 'root', 'root');
        $statement = $conn->prepare('insert into postComment(comment, imageId, userId) values(:description, :imageId, :userId)');
        $statement->bindValue(':description', $this->getDescription());
        $statement->bindValue(':userId', $this->getUserId());
        $statement->bindValue(':imageId', $this->getImageId());

        return $statement->execute();
    }
}
?>  
