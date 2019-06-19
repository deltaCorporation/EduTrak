<?php

class ProposalAndQuotes{

    private $_db,
            $_data,
            $_proposals,
            $_quotes;


    public function __construct($ntf = null){
        $this->_db = DB::getInstance();

        if($ntf){
            $this->find($ntf);
        }
    }

    public function update($fields = array(), $id = null){
        if(!$this->_db->update('proposals_and_quotes', $id, $fields)){
            throw new Exception('There was a problem updating.');
        }

    }

    public function create($fields = array()){
        if(!$this->_db->insert('proposals_and_quotes', $fields)){
            throw new Exception('There was a problem creating an Proposal / Quote.');
        }
    }

    public function createDetails($fields = array()){
        if(!$this->_db->insert('proposals_and_quotes_details', $fields)){
            throw new Exception('There was a problem creating an Proposal / Quote details.');
        }
    }

    public function delete($ntf){
        if(!$this->_db->delete('proposals_and_quotes', array('id', '=', $ntf))){
            throw new Exception('There was a problem deleting an Proposal / Quote.');
        }
    }

    public function find($ntf = null){
        if($ntf){

            $data = $this->_db->get('proposals_and_quotes', array('ID', '=', $ntf));

            if($data->count()){
                $this->_data = $data->first();

                return true;
            }
        }
        return false;
    }

    public function getProposals($customerID){
        $this->_proposals = $this->_db->query('SELECT * FROM proposals_and_quotes WHERE type = "proposal" AND customerID = '.$customerID, array());
        return $this->_db->results();
    }

    public function getQuotes($customerID){
        $this->_quotes = $this->_db->query('SELECT * FROM proposals_and_quotes WHERE type = "quote" AND customerID = '.$customerID, array());
        return $this->_db->results();
    }

    public function getDetails($id){
        $this->_quotes = $this->_db->query('SELECT * FROM proposals_and_quotes_details WHERE proposalQuoteID = '.$id, array());
        return $this->_db->results();
    }

    public function exists(){
        return (!empty($this->_data)) ? true : false;
    }

    public function data(){
        return $this->_data;
    }



}