<?php

class Lead{

    private $_db,
            $_data,
            $_leads,
            $_categories;


    public function __construct($lead = null){
        $this->_db = DB::getInstance();

        if($lead){
            $this->find($lead);
        }
    }

    public function update($fields = array(), $id = null){
        if(!$this->_db->update('leads', $id, $fields)){
            throw new Exception('There was a problem updating.');
        }

    }

    public function create($fields = array()){
        if(!$this->_db->insert('leads', $fields)){
            throw new Exception('There was a problem creating an lead.');
        }
    }

    public function delete($lead){
        if(!$this->_db->delete('leads', array('id', '=', $lead))){
            throw new Exception('There was a problem deleting an lead.');
        }
    }

    public function updateAdditionalInfo($fields = array(), $id = null){
        if(!$this->_db->updateAdditionalInfo('school_additional_information', $id, $fields)){
            throw new Exception('There was a problem updating.');
        }

    }

    public function createAdditionalInfo($fields = array()){
        if(!$this->_db->insert('school_additional_information', $fields)){
            throw new Exception('There was a problem adding additional information.');
        }
    }

    public function deleteAdditionalInf($lead){
        if(!$this->_db->delete('school_additional_information', array('id', '=', $lead))){
            throw new Exception('There was a problem deleting an lead.');
        }
    }

    public function find($lead = null){
        if($lead){

            $data = $this->_db->get('leads', array('id', '=', $lead));

            if($data->count()){
                $this->_data = $data->first();

                return true;
            }
        }
        return false;
    }

    public function getLeads(){
        $this->_leads = $this->_db->query('SELECT leads.id, leads.prefix, leads.firstName, leads.lastName, leads.jobTitle, leads.category, leads.company, leads.reachedUsBy, leads.partner, leads.partnerRep, leads.description, leads.tags, leads.lastContacted, leads.followUpDescription, leads.followUpDate, leads.officePhone, leads.phoneExt, leads.mobilePhone, leads.email, leads.street, leads.city, leads.district, leads.country, leads.state, leads.zip, leads.facebook, leads.twitter, leads.linkedIn, leads.website, leads.createdBy, leads.modifiedBy, leads.createdOn, leads.modifiedOn, CONCAT(users.firstName, " ", users.lastName) AS assignedTo FROM `leads` INNER JOIN users ON leads.assignedTo = users.id ORDER BY leads.id DESC', array());

        return $this->_db->results();
    }

    public function getAdditionalInfo($leadID){
        $this->_leads = $this->_db->query('SELECT * FROM school_additional_information WHERE leadID = '.$leadID, array());

        return $this->_db->results();
    }

    public function exists(){
        return (!empty($this->_data)) ? true : false;
    }

    public function data(){
        return $this->_data;
    }

    public function countNotes($contactsID , $section){
        $this->_db->query("SELECT COUNT(*) as count FROM notes WHERE section = '".$section."' AND contactsID = ".$contactsID, array());

        return $this->_db->first()->count;


    }
    
    public function getCategories(){
    	$this->_categories = $this->_db->query('SELECT category FROM categories ORDER BY id', array());

        return $this->_db->results();
    }

}