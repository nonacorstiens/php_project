<?php
    class Post
    {
        private $image;
        private $imageDescription;
        private $imageCrop;
        private $userId;
        private $location;

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
                $statement = $conn->prepare('INSERT INTO post(imageName,imageDescription, imageCrop, userId) values(:image, :imageDescription, :imageCrop, :userId)');
                $statement->bindParam(':image', $this->image);
                $statement->bindParam(':imageCrop', $this->imageCrop);
                $statement->bindParam(':imageDescription', $this->imageDescription);
                $statement->bindParam(':userId', $this->userId);
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
            $statement = $conn->prepare('select * from post order by uploadDate desc');
            $result = $statement->execute();

            return $statement->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        }

        public static function searchTags($term)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("select * from post where imageDescription LIKE '%$term%'");
            $result = $statement->execute();
            $searchResults = $statement->fetchAll(PDO::FETCH_CLASS, __CLASS__);

            return $searchResults;
        }
    }
