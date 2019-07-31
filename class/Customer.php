<?php

class Customer{

    private $_db,
            $_data,
            $_customer,
            $_contact,
            $_categories,
            $_listNo = 15;
          


    public function __construct($customer = null){
        $this->_db = DB::getInstance();

        if($customer){
            $this->find($customer);
        }
    }

    public function update($fields = array(), $id = null){
        if(!$this->_db->update('customers', $id, $fields)){
            throw new Exception('There was a problem updating.');
        }

    }

    public function create($fields = array()){
        if(!$this->_db->insert('customers', $fields)){
            throw new Exception('There was a problem creating an lead.');
        }
    }

    public function delete($customer){
        if(!$this->_db->delete('customers', array('id', '=', $customer))){
            throw new Exception('There was a problem deleting an lead.');
        }
    }

    public function find($customer = null){
        if($customer){

            $data = $this->_db->get('customers', array('id', '=', $customer));

            if($data->count()){
                $this->_data = $data->first();

                return true;
            }
        }
        return false;
    }
    
    public function checkIfExists($customer){
        if($customer){

            $data = $this->_db->get('customers', array('name', '=', $customer));

            if($data->count()){
                $this->_data = $data->first();

                return true;
            }
            
            return false;
        }
        return false;
    }

    public function getCustomers($case = null, $page = null, $sort = array(), $order = null,  $filters = null){

        switch ($case){
            case 'list':

                $sql = "
                  SELECT 
                    customers.id as id, 
                    TRIM(customers.name) as name, 
                    TRIM(customers.category) as category, 
                    TRIM(customers.partnerRep) as partnerRep, 
                    TRIM(customers.partner) as partner, 
                    TRIM(customers.parentCustomer) as parentCustomer, 
                    TRIM(customers.officePhone) as officePhone, 
                    TRIM(customers.email) as email, 
                    TRIM(customers.lastContacted) as lastContacted
                  FROM 
                    customers ";

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
                    $sql.= "ORDER BY ID DESC ";
                }

                if($page !== null){
                    $sql .= "LIMIT {$offset}, {$this->_listNo}";
                }

//                echo $sql;die;

                $this->_customer = $this->_db->query($sql);
                break;

            default:
                $this->_customer = $this->_db->query('SELECT * FROM customers ORDER BY id DESC', array());
                break;
        }


        return $this->_db->results();
    }

    public function getAdditionalInfo($customerID){
        $this->_customer = $this->_db->query('SELECT * FROM school_additional_information WHERE customerID = '.$customerID, array());

        return $this->_db->results();
    }

    public function createAdditionalInfo($fields = array()){
        if(!$this->_db->insert('school_additional_information', $fields)){
            throw new Exception('There was a problem adding additional information.');
        }
    }

    public function updateAdditionalInfoCustomer($fields = array(), $id = null){
        if(!$this->_db->updateAdditionalInfoCustomer('school_additional_information', $id, $fields)){
            throw new Exception('There was a problem updating.');
        }

    }
    
     public function getContacts($id){
        $this->_contact = $this->_db->query('SELECT contacts.prefix, contacts.firstName, contacts.lastName, contacts.id FROM contacts WHERE contacts.customerID = '.$id.' ', array());

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

    public function countEvent($customerID){
        $this->_db->query('SELECT COUNT(*)AS count FROM events WHERE events.customerID = '.$customerID, array());

        return $this->_db->first()->count;
    }
    
    public function getCategories(){
    	$this->_categories = $this->_db->query('SELECT category FROM categories ORDER BY id', array());

        return $this->_db->results();
    }

}