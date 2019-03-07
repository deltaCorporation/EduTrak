<?php

class Image{

    private $_db;
    private $_errors;
    private $_passed;

    public function __construct(){
        $this->_db = DB::getInstance();
    }

    public function upload($path, $position){

        $targetFile = $path.$_FILES['img']["name"];
        $fileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

        $filePath = $path.$position.'.'.$fileType;

        move_uploaded_file($_FILES['img']['tmp_name'], $filePath);

        return $fileType;
    }

    public function check($size, $extensions = array()){

        if ($_FILES["img"]["size"] > $size) {
            $this->addError('File is to large!');
        }

        $imageFileType = strtolower(pathinfo($_FILES['img']['name'],PATHINFO_EXTENSION));

        if(!in_array($imageFileType, $extensions)){
            $this->addError('Wrong file format!');
        }

        if(empty($this->_errors)){
            $this->_passed = true;
        }

        return $this;

    }

    public function exists($name){
        if(!empty($name)){
            return true;
        }
        return false;
    }

    private function addError($error){
        $this->_errors[] = $error;
    }

    public function errors(){
        return $this->_errors;
    }

    public function passed(){
        return $this->_passed;
    }

}