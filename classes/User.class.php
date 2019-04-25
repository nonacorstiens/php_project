<?php
require_once("functions.inc.php");
    class User{
        private $firstName; 
        private $lastName; 
        private $userName;
        private $email;
        private $password;
        private $passwordConfirmation;
        private $image;
        private $description;

        /**
         * Get the value of firstName
         */ 
        public function getFirstName()
        {
                return $this->firstName;
        }

        /**
         * Set the value of firstName
         *
         * @return  self
         */ 
        public function setFirstName($firstName)
        {
                $this->firstName = $firstName;

                return $this;
        }

        /**
         * Get the value of lastName
         */ 
        public function getLastName()
        {
                return $this->lastName;
        }

        /**
         * Set the value of lastName
         *
         * @return  self
         */ 
        public function setLastName($lastName)
        {
                $this->lastName = $lastName;

                return $this;
        }

        /**
         * Get the value of userName
         */ 
        public function getUserName()
        {
                return $this->userName;
        }

        /**
         * Set the value of userName
         *
         * @return  self
         */ 
        public function setUserName($userName)
        {
                $this->userName = $userName;

                return $this;
        }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }

        /**
         * Get the value of password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Set the value of password
         *
         * @return  self
         */ 
        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }

        /**
         * Get the value of passwordConfirmation
         */ 
        public function getPasswordConfirmation()
        {
                return $this->passwordConfirmation;
        }

        /**
         * Set the value of passwordConfirmation
         *
         * @return  self
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


        public function register() {

                

                $password = Security::hash($this->password);

                if (canRegister($this->email, $this->password, $this->passwordConfirmation)){
    
                        try {
        
                                $conn = Db::getInstance();
                                $statement = $conn->prepare("INSERT INTO user(firstName, lastName, userName, email, password) values (:firstName, :lastName, :userName, :email, :password)");
                                $statement->bindParam(":firstName", $this->firstName);
                                $statement->bindParam(":lastName", $this->lastName);
                                $statement->bindParam(":userName", $this->userName);
                                $statement->bindParam(":email", $this->email);
                                $statement->bindParam(":password", $password);
                                $result = $statement->execute();
                        
        
                        return $result;
                        
                        } catch ( Throwable $t ) {
                        return false;
                        }
                        
                } else {
                        
                }
            }

            public function login(){
                // email en password opvragen
                $conn = Db::getInstance();
                // userName zoeken in db
                $statement = $conn->prepare("SELECT * from user where userName = :userName");
                $statement->bindParam(":userName", $this->userName);
                $result = $statement->execute();

                $user = $statement->fetch(PDO::FETCH_ASSOC);

                if(password_verify($this->password, $user['password'])){
                        $_SESSION['userid'] = $user['id'];
                        header('Location: index.php');
                        
                }
            }

            public function editText(){
                $conn = new PDO("mysql:host=localhost;dbname=PHPotato", "root", "root", null);
                $stm = $conn->prepare("UPDATE user SET description = :description WHERE userName = :username");
                $stm->bindParam(":username", $this->username);
                $stm->bindParam(":description", $this->description);
                $result = $stm->execute();
    
                
            }
    
            public function editEmail(){
                $conn = new PDO("mysql:host=localhost;dbname=PHPotato", "root", "root", null);
                $stm = $conn->prepare("UPDATE user SET email = :email WHERE userName = :username");
                $stm->bindParam(":username", $this->username);
                $stm->bindParam(":email", $this->email);
                $result = $stm->execute();
    
                
            }
    
            public function editPassword($hash){
                $conn = new PDO("mysql:host=localhost;dbname=PHPotato", "root", "root", null);
                $stm = $conn->prepare("UPDATE user SET password = :password WHERE userName = :username");
                $stm->bindParam(":username", $this->username);
                $stm->bindParam(":password", $hash);
                $result = $stm->execute();
    
                
            }
    
            public function getValues(){
                $conn = new PDO("mysql:host=localhost;dbname=PHPotato", "root", "root", null);
                $stm = $conn->prepare("SELECT * from user WHERE userName = :username");
                $stm->bindParam(":username", $this->username);
                $stm->execute();
    
                return $stm->fetch(PDO::FETCH_ASSOC);
            }
    
            public function editPicture(){
                function random_string($length) {
                    $key = '';
                    $keys = array_merge(range(0, 9), range('a', 'z'));
                
                    for ($i = 0; $i < $length; $i++) {
                        $key .= $keys[array_rand($keys)];
                    }
                
                    return $key;
                }
                
                $save_path= dirname(__FILE__) . '\..\user_images\ ';
                $myname = random_string(10).$this->image['name'];
                move_uploaded_file($this->image['tmp_name'], $save_path.$myname);
    
                $conn = new PDO("mysql:host=localhost;dbname=PHPotato", "root", "root", null);
                $stm = $conn->prepare("UPDATE user SET image = :image WHERE userName = :username");
                $stm->bindParam(":username", $this->username);
                $stm->bindParam(":image", $myname);
                $stm->execute();
            }
        

        

        
    }

  
    

?>