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
                    request_status.name as statusName ,
                    request_status.colorClass
                FROM requests 
                JOIN request_status ON statusID = request_status.ID
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

    public function deactivateRequests($caseID, $case){

        if($case === 'lead'){
            $sql = "UPDATE requests SET deleted = 1 WHERE leadID = {$caseID}";
        }else{
            $sql = "UPDATE requests SET deleted = 1 WHERE customerID = {$caseID}";
        }

        if(!$this->_db->query($sql)){
            throw new Exception('There was a problem deactivating requests.');
        }
    }

    public function getRequests(){
        $this->_requests = $this->_db->query('SELECT requests.*, request_status.colorClass FROM requests JOIN request_status ON requests.statusID = request_status.ID WHERE requests.deleted <> 1 ORDER BY ID', array());
        return $this->_db->results();
    }

    public function getLoadRequestsByID($leadID){
        $this->_requests = $this->_db->query("SELECT requests.*, request_status.colorClass FROM requests JOIN request_status ON requests.statusID = request_status.ID WHERE requests.leadID = {$leadID} AND requests.deleted <> 1 ORDER BY ID", array());
        return $this->_db->results();
    }

    public function getCustomerRequestsByID($customerID){
        $this->_requests = $this->_db->query("SELECT requests.*, request_status.colorClass FROM requests JOIN request_status ON requests.statusID = request_status.ID WHERE requests.customerID = {$customerID} AND requests.deleted <> 1 ORDER BY ID", array());
        return $this->_db->results();
    }

    public function getStatuses(){
        $this->_requests = $this->_db->query('SELECT * FROM request_status ORDER BY ID', array());
        return $this->_db->results();
    }

    public function getRequestWorkshopsByID($requestID){
        $this->_requests = $this->_db->query("SELECT * FROM requestworkshops WHERE requestworkshops.requestID = '{$requestID}'", array());
        return $this->_db->results();
    }

    public function getStatusByID($statusID){
        $this->_requests = $this->_db->query("SELECT * FROM request_status WHERE ID = {$statusID}", array());
        return $this->_db->first();
    }
}