<?php

namespace php_project;

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

    public function getAll()
    {
        $conn = Db::getInstance();
        $result = $conn->prepare('select * from postComment order by id asc');

        // fetch all records from the database and return them as objects of this __CLASS__ (Post)
        return $result->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    public function uploadComment()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare('insert into postComment(comment, userId, imageId) values(:description, :userId, :imageId)');
        $statement->bindValue(':description', $this->description);
        $statement->bindValue(':userId', $this->userId);
        $statement->bindValue(':imageId', $this->imageId);

        $result = $statement->execute();
    }
}
?>  
