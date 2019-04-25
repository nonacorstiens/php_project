<?php
    class User{
        private $firstName; 
        private $lastName; 
        private $userName;
        private $email;
        private $password;
        
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
        
        

        public function register() {

                $password = Security::hash($this->password);
    
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
            }

        
    }

  
    

?>