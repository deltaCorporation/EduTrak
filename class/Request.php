<?php

class Request{

    private $_db,
            $_data,
            $_requests;


    public function __construct($request = null){
        $this->_db = DB::getInstance();

        if($request){
            $this->find($request);
        }
    }

    public function update($fields = array(), $id = null){
        if(!$this->_db->update('requests', $id, $fields)){
            throw new Exception('There was a problem updating.');
        }
    }

    public function updateWorkshop($fields = array(), $id = null){
        if(!$this->_db->update('requestworkshops', $id, $fields)){
            throw new Exception('There was a problem updating.');
        }
    }

    public function create($fields = array()){
        if(!$this->_db->insert('requests', $fields)){
            throw new Exception('There was a problem creating an request.');
        }
    }

    public function createRequestWorkshop($fields = array()){
        if(!$this->_db->insert('requestworkshops', $fields)){
            throw new Exception('There was a problem creating an workshop request.');
        }
    }

    public function delete($request){
        if(!$this->_db->delete('requests', array('id', '=', $request))){
            throw new Exception('There was a problem deleting an request.');
        }
    }

    public function find($request = null){
        if($request){

            $data = $this->_db->query("

                SELECT 
                    requests.*, 
                    CONCAT(users.firstName,' ', users.lastName) as createdBy,
                    requeststatus.name as statusName ,
                    requeststatus.colorClass
                FROM requests 
                JOIN requeststatus ON statusID = requeststatus.ID
                JOIN users ON createdBy = users.id
                WHERE requests.ID = {$request}
                
            ");

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


    public function getRequests(){
        $this->_requests = $this->_db->query('SELECT requests.*, requeststatus.colorClass FROM requests JOIN requeststatus ON requests.statusID = requeststatus.ID ORDER BY ID', array());
        return $this->_db->results();
    }

    public function getLeadRequestsByID($leadID){
        $this->_requests = $this->_db->query("SELECT requests.*, requeststatus.colorClass FROM requests JOIN requeststatus ON requests.statusID = requeststatus.ID WHERE requests.leadID = {$leadID} ORDER BY ID", array());
        return $this->_db->results();
    }

    public function getCustomerRequestsByID($customerID){
        $this->_requests = $this->_db->query("SELECT requests.*, requeststatus.colorClass FROM requests JOIN requeststatus ON requests.statusID = requeststatus.ID WHERE requests.customerID = {$customerID} ORDER BY ID", array());
        return $this->_db->results();
    }

    public function getStatuses(){
        $this->_requests = $this->_db->query('SELECT * FROM requeststatus ORDER BY ID', array());
        return $this->_db->results();
    }

    public function getRequestWorkshopsByID($requestID){
        $this->_requests = $this->_db->query("SELECT * FROM requestworkshops WHERE requestworkshops.requestID = '{$requestID}'", array());
        return $this->_db->results();
    }

    public function getStatusByID($statusID){
        $this->_requests = $this->_db->query("SELECT * FROM requeststatus WHERE ID = {$statusID}", array());
        return $this->_db->first();
    }
}