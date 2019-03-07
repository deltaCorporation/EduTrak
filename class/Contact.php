<?php

class Contact{

    private $_db,
            $_data,
            $_contacts,
            $_categories;


    public function __construct($contact = null){
        $this->_db = DB::getInstance();

        if($contact){
            $this->find($contact);
        }
    }

    public function update($fields = array(), $id = null){
        if(!$this->_db->update('contacts', $id, $fields)){
            throw new Exception('There was a problem updating an contact.');
        }

    }

    public function create($fields = array()){
        if(!$this->_db->insert('contacts', $fields)){
            throw new Exception('There was a problem creating an contact.');
        }
    }

    public function delete($contact){
        if(!$this->_db->delete('contacts', array('id', '=', $contact))){
            throw new Exception('There was a problem deleting an contact.');
        }
    }

    public function find($contact = null){
        if($contact){

            $data = $this->_db->get('contacts', array('id', '=', $contact));

            if($data->count()){
                $this->_data = $data->first();

                return true;
            }
        }
        return false;
    }

    public function getContacts(){
        $this->_contacts = $this->_db->query('SELECT * FROM contacts ORDER BY id DESC', array());

        return $this->_db->results();
    }

    public function exists(){
        return (!empty($this->_data)) ? true : false;
    }

    public function data(){
        return $this->_data;
    }


    public function countNotes($contactsID , $section ){
        $this->_db->query("SELECT COUNT(*) as count FROM notes WHERE section = '".$section."' AND contactsID = ".$contactsID, array());

        return $this->_db->first()->count;

    }
    
    public function getCategories(){
    	$this->_categories = $this->_db->query('SELECT category FROM categories ORDER BY id', array());

        return $this->_db->results();
    }

}