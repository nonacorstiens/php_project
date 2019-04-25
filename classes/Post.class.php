<?php
    class Post{
        private $image; 
        private $imageDescription; 
        private $imageCrop;
        
        public function getImageDescription()
        {
                return $this->imageDescription;
        }

        /**
         * Set the value of uploadDescription
         *
         * @return  self
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
         * Set the value of upload
         *
         * @return  self
         */ 
        public function setImage($image)
        {
                $this->image = $image;

                return $this;
        }
        public function getImageCrop()
        {
                return $this->imageCrop;
        }

        /**
         * Set the value of uploadCrop
         *
         * @return  self
         */ 
        public function setImageCrop($imageCrop)
        {
                $this->imageCrop = $imageCrop;

                return $this;
        }

        public function uploadImage(){
            if(!empty($this->image && $this->imageDescription)){
                $conn = new PDO("mysql:host=localhost;dbname=PHPotato;", "root", "root", null);
                $statement = $conn->prepare("INSERT INTO post(imageName,imageDescription) values(:image, :imageDescription)");
                $statement->bindParam(":image", $this->image);
                $statement->bindParam(":imageDescription", $this->imageDescription);
                $result = $statement->execute(); 
                return true;
                }
                else{
                    echo "error";
                }
       
        }
       
    }

  
    

?>