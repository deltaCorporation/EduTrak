<?php

class Contact{

    private $_db,
            $_data,
            $_contacts,
            $_categories,
            $_listNo = 15;


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

//    public function getContacts(){
//        $this->_contacts = $this->_db->query('SELECT * FROM contacts ORDER BY id DESC', array());
//
//        return $this->_db->results();
//    }

    public function getContacts($case = null, $page = null, $sort = array(), $order = null,  $filters = null){

        switch ($case){
            case 'list':

                $sql = "
                  SELECT 
                    contacts.id as id,
                    TRIM(contacts.firstName) as firstName, 
                    TRIM(contacts.lastName) as lastName,
                    TRIM(contacts.jobTitle) as jobTitle,
                    TRIM(contacts.category) as category,
                    TRIM(contacts.customer) as customer,
                    TRIM(contacts.officePhone) as officePhone,
                    TRIM(contacts.email) as email,
                    TRIM(contacts.lastContacted) as lastContacted
                  FROM 
                    contacts ";

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

                $this->_contacts = $this->_db->query($sql);
                break;

            default:
                $this->_contacts = $this->_db->query('SELECT * FROM contacts ORDER BY id DESC', array());
                break;
        }


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

    public function getCustomerID($customerName){
        $this->_db->query('SELECT id FROM customers WHERE customers.name = "'.$customerName.'"', array());

        if($this->_db->results()){
            return $this->_db->first();
        }else{
            return false;
        }

    }

    public function getCategories(){
    	$this->_categories = $this->_db->query('SELECT category FROM categories ORDER BY id', array());

        return $this->_db->results();
    }

}