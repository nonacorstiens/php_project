<?php
    class Post{
        private $upload; 
        private $uploadDescription; 
        
        public function getUploadDescription()
        {
                return $this->uploadDescription;
        }

        /**
         * Set the value of uploadDescription
         *
         * @return  self
         */ 
        public function setUploadDescription($uploadDescription)
        {
                $this->uploadDescription = $uploadDescription;

                return $this;
        }

        /**
         * Get the value of upload
         */ 
        public function getUpload()
        {
                return $this->upload;
        }

        /**
         * Set the value of upload
         *
         * @return  self
         */ 
        public function setUpload($upload)
        {
                $this->upload = $upload;

                return $this;
        }

        public function uploadFile(){
            if(!empty($this->upload)){
                $conn = new PDO("mysql:host=localhost;dbname=PHPotato;", "root", "root", null);
                $statement = $conn->prepare("INSERT INTO post(image,description) values(:upload, :uploadDescription)");
                $statement->bindParam(":upload", $this->upload);
                $statement->bindParam(":uploadDescription", $this->uploadDescription);
                $result = $statement->execute(); 
                return true;
                //$uploadCheck = true;
                //return $uploadCheck;
                //if(!empty($_POST['uploadDescription'])){
                    //$descriptionCheck = true;
                    //$result = $statement->execute();
                    //return $result;
                    //return $descriptionCheck;
                }
                else{
                    echo "error";
                    //$descriptionCheck = false;
                    //return $descriptionCheck;
                }
            //}
            //else{
                //$uploadCheck = false;
                //return $uploadCheck;
            //}*/
        }
    }

  
    

?>