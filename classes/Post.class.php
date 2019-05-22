<?php
    class Post
    {
        private $image;
        private $imageDescription;
        private $imageCrop;
        private $userId;
        private $location;
        private $filter;

        public function getImageDescription()
        {
            return $this->imageDescription;
        }

        /**
         * Set the value of uploadDescription.
         *
         * @return self
         */
        public function setImageDescription($imageDescription)
        {
            $this->imageDescription = $imageDescription;

            return $this;
        }

        public function getImage()
        {
            return $this->image;
        }

        /**
         * Set the value of upload.
         *
         * @return self
         */
        public function setImage($image)
        {
            $this->image = $image;

            return $this;
        }

        /**
         * Get the value of imageCrop.
         */
        public function getImageCrop()
        {
            return $this->imageCrop;
        }

        /**
         * Set the value of imageCrop.
         *
         * @return self
         */
        public function setImageCrop($imageCrop)
        {
            $this->imageCrop = $imageCrop;

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
         * Get the value of filter.
         */
        public function getFilter()
        {
            return $this->filter;
        }

        /**
         * Set the value of filter.
         *
         * @return self
         */
        public function setFilter($filter)
        {
            $this->filter = $filter;

            return $this;
        }

        public function uploadImage($imageFile)
        {
            try {
                $fileType = strtolower(explode('.', $imageFile['name'])[1]); // bepaal het type bestand, [1] --> neem alle stringelementen na het punt
                $fileError = $imageFile['error'];
                Post::checkImage($fileType, $fileError);
                $fileSize = $imageFile['size'];
                Post::checkSize($fileSize);

                $target_dir = 'uploads/full/';
                $newFileName = uniqid('', true).'.'.$fileType; //uniqid creeert nieuwe naam timebased. lege prefix zorgt voor 13 karakters lang. True voor extra annex.
                $fileLocation = $target_dir.$newFileName;
                move_uploaded_file($imageFile['tmp_name'], $fileLocation); // 'tmp' checkt of het een valabele file is upgeload via POST mechanisme.
                return $fileLocation;
            } catch (Exception $e) {
                return $e;
            }
        }

        private static function checkImage($fileType, $fileError)
        {
            $allowed = ['png', 'jpg', 'gif', 'jpeg'];
            if (!(in_array($fileType, $allowed))) { // checken of $filetype terug te vinden is in de array allowed.
                throw new Exception("The file you're trying to upload has the wrong format. Only PNG, JPG, JPEG and GIF are excepted.");
            }
            if (!$fileError == 0) { // als de error iets anders terug geeft dan 0 is er een probleem bij de upload
                throw new Exception('Something went wrong, try again');
            }
        }

        private static function checkSize($fileSize)
        {
            $maxSizeMB = 2; //MB
                $maxSizeBytes = $maxSizeMB * 1024 * 1024; // omzetten naar bytes
                if ($fileSize > $maxSizeBytes) {
                    throw new Exception("The file you're trying to upload is too big. Max 2MB");
                }
        }

        public function uploadDB()
        {
            if (!empty($this->image && $this->imageDescription)) {
                $conn = Db::getInstance();
                $statement = $conn->prepare('INSERT INTO post(imageName,imageDescription, imageCrop, userId, location, filter) values(:image, :imageDescription, :imageCrop, :userId, :location, :filter)');
                $statement->bindParam(':image', $this->image);
                $statement->bindParam(':imageCrop', $this->imageCrop);
                $statement->bindParam(':imageDescription', $this->imageDescription);
                $statement->bindParam(':userId', $this->userId);
                $statement->bindParam(':location', $this->location);
                $statement->bindParam(':filter', $this->filter);
                $result = $statement->execute();

                return true;
            }
        }

        public function cropImage($imageLink)
        {
            try {
                $image = Post::createImageByType($imageLink); //image aanmaken van de geuploade file

                $centerX = imagesx($image) / 2;
                $centerY = imagesy($image) / 2; //centerpunt bepalen

                $size = 500; //grootte crop bepalen

                $x = $centerX - ($size / 2);
                $y = $centerY - ($size / 2); // crop in het midden plaatsen

                $rect = ['x' => $x, 'y' => $y, 'width' => $size, 'height' => $size];

                $imageCrop = imagecrop($image, $rect);

                $newFileName = uniqid('', true).'.jpeg';

                $fileLocation = 'uploads/cropped/'.$newFileName;

                imagejpeg($imageCrop, $fileLocation);

                imagedestroy($imageCrop);

                return $fileLocation;
            } catch (Exception $e) {
            }
        }

        private static function createImageByType($imageFile)
        {
            $fileAnnex = explode('.', $imageFile);
            $fileType = strtolower(end($fileAnnex));
            switch ($fileType) {
                    case 'png':
                        return imagecreatefrompng($imageFile);
                        break;
                    case 'gif':
                        return imagecreatefromgif($imageFile);
                        break;
                    default:
                        return imagecreatefromjpeg($imageFile);
                }
        }

        public static function getAll()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare('select * from post where active = "1" order by uploadDate desc');
            $result = $statement->execute();

            return $statement->fetchAll();
        }

        public static function searchTags($term)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("select * from post where imageDescription LIKE '%$term%'");
            $result = $statement->execute();
            $searchResults = $statement->fetchAll();

            return $searchResults;
        }

        public static function getPostById($id)
        {
            try {
                $conn = Db::getInstance();
                $statement = $conn->prepare('select * from post where id = :id ');
                $statement->bindParam(':id', $id);
                $result = $statement->execute();

                $post = $statement->fetch(PDO::FETCH_ASSOC);

                return $post;
            } catch (Exception $e) {
            }
        }

        public static function setInactive($imageId)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare('UPDATE post SET active = "0" WHERE id = :imageId');
            $statement->bindParam(':imageId', $imageId);
            $statement->execute();
        }

        public static function uploadReportToDB($imageId, $userId)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare('INSERT INTO reportedPost(imageId, userId) values(:imageId, :userId)');
            $statement->bindParam(':imageId', $imageId);
            $statement->bindParam(':userId', $userId);
            $statement->execute();
        }

        public function setInappropriate($imageId, $userId)
        {
            $conn = Db::getInstance();
            //$conn = new PDO('mysql:host=localhost;dbname=PHPotato;charset=utf8mb4', 'root', 'root');
            $statement = $conn->prepare('SELECT * from reportedPost where imageId = :imageId');
            $statement->bindParam(':imageId', $imageId);
            $statement->execute();
            $reports = $statement->fetchAll(PDO::FETCH_ASSOC);
            $count = $statement->rowCount();
            try {
                if ($count == 0) {
                    Post::uploadReportToDB($imageId, $userId);

                    return 'ok';
                } else {
                    if ($count >= 2) {
                        Post::setInactive($imageId);

                        return 'deleted';
                    } else {
                        foreach ($reports as $report) {
                            if ($report['userId'] == $userId) {
                                return 'false';
                            } else {
                                Post::uploadReportToDB($imageId, $userId);

                                return 'ok';
                            }
                        }
                    }
                }
            } catch (Exception $e) {
            }
        }

        /**
         * Get the value of location.
         */
        public function getLocation()
        {
            return $this->location;
        }

        /**
         * Set the value of location.
         *
         * @return self
         */
        public function setLocation($location)
        {
            $this->location = $location;

            return $this;
        }

        public static function getAllFilters()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare('select * from filter');
            $result = $statement->execute();

            // fetch all records from the database and return them as objects of this __CLASS__ (Post)
            return $statement->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result);
        }

        public static function time_ago($time)
        {
            $out = ''; // what we will print out
            $now = time(); // current time
            $diff = $now - $time + 7200; // difference between the current and the provided dates + 2 uur tijdsverschil -> 1 uur tijdszone en 1 uur zomer/winteruur

        if ($diff < 60) { // it happened now
            echo 'Posted just now';
        } elseif ($diff < 3600) { // it happened X minutes ago
            $out = round($diff / 60);
            if ($out == 1) {
                echo 'Posted '.$out.' minute ago';
            } else {
                echo 'Posted '.$out.' minutes ago';
            }
        } elseif ($diff < 3600 * 24) { // it happened X hours ago
            $out = round($diff / 3600);
            if ($out == 1) {
                echo 'Posted '.$out.' hour ago';
            } else {
                echo 'Posted '.$out.' hours ago';
            }
        } elseif ($diff < 3600 * 24 * 2) { // it happened yesterday
            echo 'Posted yesterday';
        } elseif ($diff > 3600 * 24 * 2 && $diff < 3600 * 24 * 7) {
            $out = round($diff / (3600 * 24));
            echo 'Posted '.$out.' days ago';
        } elseif ($diff > 3600 * 24 * 7 && $diff < 3600 * 24 * 14) {
            echo 'Posted more than a week ago';
        } else {
            echo 'Posted on '.gmdate('Y-m-d H:i:s', $time);
        }
        }
    }
