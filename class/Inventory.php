<?php

class Inventory{

    private $_db,
            $_data,
            $_item,
            $_workshops;


    public function __construct($item = null){
        $this->_db = DB::getInstance();

        if($item){
            $this->find($item);
        }
    }

    public function update($fields = array(), $id = null){
        if(!$this->_db->update('inventory', $id, $fields)){
            throw new Exception('There was a problem updating.');
        }

    }

    public function create($fields = array()){
        if(!$this->_db->insert('inventory', $fields)){
            throw new Exception('There was a problem creating an inventory item.');
        }
    }

    public function delete($item){
        if(!$this->_db->delete('inventory', array('id', '=', $item))){
            throw new Exception('There was a problem deleting an inventory item.');
        }
    }

    public function find($item = null){
        if($item){

            $data = $this->_db->get('inventory', array('id', '=', $item));

            if($data->count()){
                $this->_data = $data->first();

                return true;
            }
        }
        return false;
    }

    public function exists(){
        return (!empty($this->_data)) ? true : false;
    }

    public function data(){
        return $this->_data;
    }
    
    public function getInventory(){
    	$this->_db->query('SELECT id, TRIM(inventory.workshopGroups) as workshopGroups, TRIM(inventory.eduscapeSKU) as eduscapeSKU, TRIM(inventory.track) as track, TRIM(inventory.format) as format, TRIM(inventory.time) as time, TRIM(inventory.status) as status, TRIM(inventory.titleOfOffering) as titleOfOffering FROM inventory ORDER BY eduscapeSKU', array());

        return $this->_db->results();
    }

    public function getFix(){
        $this->_db->query('SELECT * FROM inventory', array());

        return $this->_db->results();
    }

    public function getWorkshops(){
        $this->_db->query('SELECT DISTINCT inventory.titleOfOffering, inventory.ID FROM inventory', array());

        return $this->_db->results();
    }
    
    public function getFilterItems($filterGroup){
    	$this->_db->query('SELECT DISTINCT TRIM('.$filterGroup.') as '.$filterGroup.' FROM inventory', array());

        return $this->_db->results();
    }

}