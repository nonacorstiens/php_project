<?php

require_once 'functions.inc.php';
    class User
    {
        private $firstName;
        private $lastName;
        private $userName;
        private $email;
        private $password;
        private $passwordConfirmation;
        private $image;
        private $description;
        private $id;

        private $passwordOld;

        private $imageCrop;

        /**
         * Get the value of firstName.
         */
        public function getFirstName()
        {
            return $this->firstName;
        }

        /**
         * Set the value of firstName.
         *
         * @return self
         */
        public function setFirstName($firstName)
        {
            $this->firstName = $firstName;

            return $this;
        }

        /**
         * Get the value of lastName.
         */
        public function getLastName()
        {
            return $this->lastName;
        }

        /**
         * Set the value of lastName.
         *
         * @return self
         */
        public function setLastName($lastName)
        {
            $this->lastName = $lastName;

            return $this;
        }

        /**
         * Get the value of userName.
         */
        public function getUserName()
        {
            return $this->userName;
        }

        /**
         * Set the value of userName.
         *
         * @return self
         */
        public function setUserName($userName)
        {
            $this->userName = $userName;

            return $this;
        }

        /**
         * Get the value of email.
         */
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * Set the value of email.
         *
         * @return self
         */
        public function setEmail($email)
        {
            $this->email = $email;

            return $this;
        }

        /**
         * Get the value of password.
         */
        public function getPassword()
        {
            return $this->password;
        }

        /**
         * Set the value of password.
         *
         * @return self
         */
        public function setPassword($password)
        {
            $this->password = $password;

            return $this;
        }

        /**
         * Get the value of passwordConfirmation.
         */
        public function getPasswordConfirmation()
        {
            return $this->passwordConfirmation;
        }

        /**
         * Set the value of passwordConfirmation.
         *
         * @return self
         */
        public function setPasswordConfirmation($passwordConfirmation)
        {
            $this->passwordConfirmation = $passwordConfirmation;

            return $this;
        }

        public function getImage()
        {
            return $this->image;
        }

        public function setImage($image)
        {
            $this->image = $image;

            return $this;
        }

        public function getDescription()
        {
            return $this->description;
        }

        public function setDescription($description)
        {
            $this->description = $description;

            return $this;
        }

        /**
         * Get the value of id.
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Set the value of id.
         *
         * @return self
         */
        public function setId($id)
        {
            $this->id = $id;

            return $this;
        }

        /**
         * Set the value of passwordOld.
         *
         * @return self
         */
        public function setPasswordOld($passwordOld)
        {
            $this->passwordOld = $passwordOld;

            return $this;
        }

        public function register()
        {
            $password = Security::hash($this->password);
            if (canRegister($this->firstName, $this->lastName, $this->userName, $this->email, $this->password, $this->passwordConfirmation)) {
                $conn = Db::getInstance();
                $statement = $conn->prepare('INSERT INTO user(firstName, lastName, userName, email, password) values (:firstName, :lastName, :userName, :email, :password)');
                $statement->bindParam(':firstName', $this->firstName);
                $statement->bindParam(':lastName', $this->lastName);
                $statement->bindParam(':userName', $this->userName);
                $statement->bindParam(':email', $this->email);
                $statement->bindParam(':password', $password);
                $result = $statement->execute();

                return $result;

                unset($_SESSION['errors']);
            }
        }

        public function login()
        {
            // username en password opvragen
            $conn = Db::getInstance();
            // userName zoeken in db
            $statement = $conn->prepare('SELECT * from user where userName = :userName');
            $statement->bindParam(':userName', $this->userName);
            $result = $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user != false) {
                if (password_verify($this->password, $user['password'])) {
                    $this->id = $user['id'];
                    $this->firstName = $user['firstName'];

                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function getValues()
        {
            $conn = Db::getInstance();
            $stm = $conn->prepare('SELECT * from user WHERE id = :id');
            $stm->bindParam(':id', $this->id);
            $stm->execute();
            $userValues = $stm->fetch(PDO::FETCH_ASSOC);

            return $userValues;
        }

        public function changeEmail()
        {
            $conn = Db::getInstance();
            $stm = $conn->prepare('UPDATE user SET email = :email WHERE id = :id');
            $stm->bindParam(':id', $this->id);
            $stm->bindParam(':email', $this->email);
            $result = $stm->execute();
        }

        public function changePassword()
        {
            $password = Security::hash($this->password);
            if (canChangePassword($this->password, $this->passwordConfirmation)) {
                $conn = Db::getInstance();
                $statement = $conn->prepare('UPDATE user SET password = :password WHERE id = :id');
                $statement->bindParam(':id', $this->id);
                $statement->bindParam(':password', $password);
                $result = $statement->execute();

                return $result;
                unset($_SESSION['errors']);
            }
        }

        public function changeDescription()
        {
            if (validDescription($this->description)) {
                $conn = Db::getInstance();
                $statement = $conn->prepare('UPDATE user SET description = :description WHERE id = :id');
                $statement->bindParam(':id', $this->id);
                $statement->bindParam(':description', $this->description);
                $result = $statement->execute();

                return $result;
                unset($_SESSION['errors']);
            }
        }

        /////////////////////// PROFILE IMAGE UPLOADEN ////////////////////////////////

        public function uploadImageImg($imageFile)
        {
            try {
                $fileType = strtolower(explode('.', $imageFile['name'])[1]); // bepaal het type bestand, [1] --> neem alle stringelementen na het punt
                $fileError = $imageFile['error'];
                User::checkImageImg($fileType, $fileError);
                $fileSize = $imageFile['size'];
                User::checkSizeImg($fileSize);

                $target_dir = 'uploads/fullProfileImage/';
                $newFileName = uniqid('', true).'.'.$fileType; //uniqid creeert nieuwe naam timebased. lege prefix zorgt voor 13 karakters lang. True voor extra annex.
                $fileLocation = $target_dir.$newFileName;
                move_uploaded_file($imageFile['tmp_name'], $fileLocation); // 'tmp' checkt of het een valabele file is upgeload via POST mechanisme.
                return $fileLocation;
            } catch (Exception $e) {
                return $e;
            }
        }

        private static function checkImageImg($fileType, $fileError)
        {
            $allowed = ['png', 'jpg', 'gif', 'jpeg'];
            if (!(in_array($fileType, $allowed))) { // checken of $filetype terug te vinden is in de array allowed.
                throw new Exception("The file you're trying to upload has the wrong format. Only PNG, JPG, JPEG and GIF are excepted.");
            }
            if (!$fileError == 0) { // als de error iets anders terug geeft dan 0 is er een probleem bij de upload
                throw new Exception('Something went wrong, try again');
            }
        }

        private static function checkSizeImg($fileSize)
        {
            $maxSizeMB = 2; //MB
            $maxSizeBytes = $maxSizeMB * 1024 * 1024; // omzetten naar bytes
            if ($fileSize > $maxSizeBytes) {
                throw new Exception("The file you're trying to upload is too big. Max 2MB");
            }
        }

        public function uploadDBImg($id)
        {
            if (!empty($this->image)) {
                $conn = Db::getInstance();
                $statement = $conn->prepare('UPDATE user SET profileImage = :imageCrop WHERE id = :id');
                $statement->bindParam(':imageCrop', $this->imageCrop);
                $statement->bindParam(':id', $id);
                var_dump($userId);
                $result = $statement->execute();

                return true;
                /*'UPDATE user(profileImage,description) values(:imageCrop, :description) WHERE id = :id' */
            }
        }

        public function cropImageImg($imageLink)
        {
            try {
                $image = User::createImageByTypeImg($imageLink); //image aanmaken van de geuploade file

                $centerX = imagesx($image) / 2;
                $centerY = imagesy($image) / 2; //centerpunt bepalen

                $size = 500; //grootte crop bepalen

                $x = $centerX - ($size / 2);
                $y = $centerY - ($size / 2); // crop in het midden plaatsen

                $rect = ['x' => $x, 'y' => $y, 'width' => $size, 'height' => $size];

                $imageCrop = imagecrop($image, $rect);

                $newFileName = uniqid('', true).'.jpeg';

                $fileLocation = 'uploads/profileCropped/'.$newFileName;

                imagejpeg($imageCrop, $fileLocation);

                imagedestroy($imageCrop);

                return $fileLocation;
            } catch (Exception $e) {
            }
        }

        private static function createImageByTypeImg($imageFile)
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
    }
