<?php

class Notification{

    private $_db,
            $_data,
            $_notifications,
            $_categories;


    public function __construct($ntf = null){
        $this->_db = DB::getInstance();

        if($ntf){
            $this->find($ntf);
        }
    }

    public function update($fields = array(), $id = null){
        if(!$this->_db->update('notifications', $id, $fields)){
            throw new Exception('There was a problem updating.');
        }

    }

    public function create($fields = array()){
        if(!$this->_db->insert('notifications', $fields)){
            throw new Exception('There was a problem creating an notification.');
        }
    }

    public function delete($ntf){
        if(!$this->_db->delete('notifications', array('id', '=', $ntf))){
            throw new Exception('There was a problem deleting an notification.');
        }
    }

    public function find($ntf = null){
        if($ntf){

            $data = $this->_db->get('notifications', array('id', '=', $ntf));

            if($data->count()){
                $this->_data = $data->first();

                return true;
            }
        }
        return false;
    }

    public function getNotifications(){
        $this->_notifications = $this->_db->query('SELECT * FROM notifications ORDER BY id DESC', array());

        return $this->_db->results();
    }

    public function exists(){
        return (!empty($this->_data)) ? true : false;
    }

    public function data(){
        return $this->_data;
    }
    
   

}