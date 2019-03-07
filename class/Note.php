<?php

class Note{

    private $_db,
            $_data,
            $_notes;


    public function __construct($note = null){
        $this->_db = DB::getInstance();

        if($note){
            $this->find($note);
        }
    }

    public function update($fields = array(), $id = null){
        if(!$this->_db->update('notes', $id, $fields)){
            throw new Exception('There was a problem updating note.');
        }

    }

    public function create($fields = array()){
        if(!$this->_db->insert('notes', $fields)){
            throw new Exception('There was a problem creating an note.');
        }
    }

    public function delete($note){
        if(!$this->_db->delete('notes', array('id', '=', $note))){
            throw new Exception('There was a problem deleting an note.');
        }
    }

    public function find($note = null){
        if($note){

            $data = $this->_db->get('notes', array('id', '=', $note));

            if($data->count()){
                $this->_data = $data->first();

                return true;
            }
        }
        return false;
    }

    public function getNotes(){
        $this->_notes = $this->_db->query('SELECT * FROM notes ORDER BY id DESC', array());

        return $this->_db->results();      
        
             return false;
    }

    public function exists(){
        return (!empty($this->_data)) ? true : false;
    }

    public function data(){
        return $this->_data;
    }

}