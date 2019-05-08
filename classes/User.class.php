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
            $conn = new PDO('mysql:host=localhost;dbname=PHPotato', 'root', 'root', null);
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
    }
