<?php

class Lead{

    private $_db,
            $_data,
            $_leads,
            $_categories,
            $_listNo = 15;


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

    public function createTag($fields = array()){
        if(!$this->_db->insert('tags', $fields)){
            throw new Exception('There was a problem creating an tag.');
        }
    }

    public function clearTags($caseID){
        if(!$this->_db->delete('tags', array('caseID', '=', $caseID))){
            throw new Exception('There was a problem clearing an tags.');
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

    public function getLeads($case = null, $page = null, $sort = array(), $order = null,  $filters = null){

        switch ($case){
            case 'list':

                $sql = "SELECT leads.*, DATE_FORMAT(leads.followUpDate, '%m/%d/%Y') as followUpDate,  CONCAT(users.firstName, ' ', users.lastName) as assignedToUser FROM leads ";
                $sql .= "LEFT JOIN users ON leads.assignedTo = users.id ";

                $offset = $page * $this->_listNo;

                if($filters){

                    $sql .= "HAVING ";

                    foreach ($filters as $index => $filter){
                        foreach ($filter as $key => $value){
                            $sql .= "{$key} = '{$value}' ";
                        }

                        if($index !== count($filters) - 1){
                            $sql .= "OR ";
                        }
                    }
                }

                if($sort && $order){
                    $sql.= "ORDER BY {$sort} {$order} ";
                }else{
                    $sql.= "ORDER BY id DESC ";
                }

                if($page !== null){
                    $sql .= "LIMIT {$offset}, {$this->_listNo}";
                }

//                echo $sql;die;

                $this->_leads = $this->_db->query($sql);
                break;

            default:
                $this->_leads = $this->_db->query('SELECT leads.id, leads.prefix, leads.firstName, leads.lastName, leads.jobTitle, leads.category, leads.company, leads.reachedUsBy, leads.partner, leads.partnerRep, leads.description, leads.tags, leads.lastContacted, leads.followUpDescription, leads.followUpDate, leads.officePhone, leads.phoneExt, leads.mobilePhone, leads.email, leads.street, leads.city, leads.district, leads.country, leads.state, leads.zip, leads.facebook, leads.twitter, leads.linkedIn, leads.website, leads.createdBy, leads.modifiedBy, leads.createdOn, leads.modifiedOn, CONCAT(users.firstName, " ", users.lastName) AS assignedTo FROM `leads` LEFT JOIN users ON leads.assignedTo = users.id ORDER BY leads.id DESC', array());
                break;
        }


        return $this->_db->results();
    }

    public function getFilters(){

        $data = [
            'assignedToUser' => [
                'title' => 'Assigned To',
                'content' => $this->_db->query('SELECT DISTINCT(CONCAT(users.firstName, \' \', users.lastName)) as assignedToUser FROM leads LEFT JOIN users ON leads.assignedTo = users.id WHERE assignedTo IS NOT NULL')->results()
            ],
            'eventName' => [
                'title' => 'Event',
                'content' => $this->_db->query('SELECT DISTINCT(eventName) FROM leads WHERE eventName IS NOT NULL')->results()
            ],
            'tags' => [
                'title' => 'Tags',
                'content' => '',
            ]
        ];

        return $data;
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

    public function getFollowUpLeads(){
        $this->_db->query("

            SELECT ID, company as name, followUpDate, 'lead' as caseName FROM leads 
            WHERE followUpDate <> NULL OR followUpDate <> ''
            UNION 
            SELECT ID, name, followUpDate, 'customer' as caseName FROM customers
            WHERE followUpDate <> NULL OR followUpDate <> ''

        ", []);
        return $this->_db->results();
    }

}