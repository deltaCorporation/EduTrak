<?php

class Request{

    private $_db,
            $_data,
            $_requests,
            $_listNo = 15;


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
        if(!$this->_db->update('request_workshops', $id, $fields)){
            throw new Exception('There was a problem updating.');
        }
    }

    public function updateItem($fields = array(), $id = null){
        if(!$this->_db->update('items', $id, $fields)){
            throw new Exception('There was a problem updating.');
        }
    }

    public function create($fields = array()){
        if(!$this->_db->insert('requests', $fields)){
            throw new Exception('There was a problem creating an request.');
        }
    }

    public function createItem($fields = array()){
        if(!$this->_db->insert('items', $fields)){
            throw new Exception('There was a problem creating an item.');
        }
    }

    public function createRequestWorkshop($fields = array()){
        if(!$this->_db->insert('request_workshops', $fields)){
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
                    request_status.colorClass,
                    rt.name as requestType
                FROM requests 
                JOIN request_type rt on requests.typeID = rt.ID
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
        $this->_requests = $this->_db->query("SELECT requests.*, request_status.colorClass, rt.name as typeName FROM requests JOIN request_status ON requests.statusID = request_status.ID JOIN request_type rt on requests.typeID = rt.ID WHERE requests.leadID = {$leadID} AND requests.deleted <> 1 ORDER BY ID", array());
        return $this->_db->results();
    }

    public function getCustomerRequestsByID($customerID){
        $this->_requests = $this->_db->query("SELECT requests.*, request_status.colorClass FROM requests JOIN request_status ON requests.statusID = request_status.ID WHERE requests.customerID = {$customerID} AND requests.deleted <> 1 ORDER BY ID", array());
        return $this->_db->results();
    }

    public function getStatuses($typeID = null){
        if($typeID)
            $this->_requests = $this->_db->query("SELECT * FROM request_status rs WHERE rs.requestTypeID = {$typeID} ORDER BY rs.ID", array());
        else
            $this->_requests = $this->_db->query('SELECT * FROM request_status rs ORDER BY rs.ID', array());
        return $this->_db->results();
    }

    public function getRequestWorkshopsByID($requestID){
        $this->_requests = $this->_db->query("SELECT * FROM request_workshops WHERE request_workshops.requestID = '{$requestID}'", array());
        return $this->_db->results();
    }

    public function getRequestWorkshopsForQuote($requestID){
        $this->_requests = $this->_db->query("SELECT *, COUNT(workshopTitle) as count, SUM(workshopPrice) as total FROM request_workshops WHERE request_workshops.requestID = '{$requestID}' GROUP BY workshopTitle, workshopPrice, workshopDescription, workshopLearnerOutcomes", array());
        return $this->_db->results();
    }

    public function getRequestItemsForQuote($requestID){
        $this->_requests = $this->_db->query("SELECT i.*, t. NAME as itemName, COUNT(i.itemTypeID) AS count, SUM(i.price) AS total FROM items i JOIN item_types t ON i.itemTypeID = t.id WHERE i.requestID = {$requestID} GROUP BY i.itemTypeID, i.price", array());
        return $this->_db->results();
    }

    public function getRequestItemsByID($requestID){
        $this->_requests = $this->_db->query("SELECT * FROM items JOIN item_types it on items.itemTypeID = it.id WHERE items.requestID = '{$requestID}'", array());
        return $this->_db->results();
    }

    public function getStatusByID($statusID){
        $this->_requests = $this->_db->query("SELECT * FROM request_status WHERE ID = {$statusID}", array());
        return $this->_db->first();
    }

    public function getOrders($case = null, $page = null, $sort = array(), $order = null,  $filters = null){

        switch ($case){
            case 'list':

                $sql = "
                    SELECT
                        r.ID AS orderID,
                        DATE_FORMAT(r.dateItemsShipped, '%m/%d/%Y') as dateItemsShipped,
                        COALESCE (l.firstName) AS firstName,
                        COALESCE (l.lastName) AS lastName,
                        COALESCE (l.company, c. NAME) AS company,
                        t.id,
                        t.name,
                        i.status,
                        sum(case when t.id = 1 then 1 else 0 end) as photonRobot,
                        sum(case when t.id = 2 then 1 else 0 end) as dongle,
                        sum(case when t.id = 3 then 1 else 0 end) as mat,
                        sum(case when t.id = 4 then 1 else 0 end) as lessonPlanA,
                        sum(case when t.id = 5 then 1 else 0 end) as lessonPlanB,
                        sum(case when t.id = 6 then 1 else 0 end) as lessonPlanC,
                        sum(case when t.id = 7 then 1 else 0 end) as flashcards,
                        sum(case when t.id = 8 then 1 else 0 end) as stickers
                    FROM
                        requests r
                    JOIN items i ON r.ID = i.requestID
                    JOIN item_types t ON i.itemTypeID = t.id
                    LEFT JOIN leads l ON r.leadID = l.id
                    LEFT JOIN customers c ON r.customerID = c.id
                    ";

                $offset = $page * $this->_listNo;

                $sql .= "WHERE r.deleted <> 1 ";

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
                    $sql.= "ORDER BY r.ID DESC ";
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

    public function getTypeByID($id){
        $this->_db->query("SELECT * FROM item_types WHERE ID = {$id}", array());
        return $this->_db->first();
    }

    public function getTypes(){
        $this->_db->query("SELECT * FROM request_type", array());
        return $this->_db->results();
    }

    public function getItemTypes(){
        $this->_db->query(
            "
                    SELECT 
                        t.name,
                        t.id,
                        COUNT(i.stock) as stock
                    FROM 
                        (
                            SELECT 
                                *,
                                case when requestID is null then 1 else null end stock
                            FROM
                                items
                        ) i
                    RIGHT JOIN item_types t ON i.itemTypeID = t.id
                    GROUP BY t.name
                    ORDER BY t.id
                "
            , array());
        return $this->_db->results();
    }

    public function getAvailableItemByID($id){
        $this->_db->query("SELECT items.*, it.name FROM items JOIN item_types it on items.itemTypeID = it.id WHERE itemTypeID = {$id} AND requestID IS NULL", array());
        if($this->_db->count() !== 0){
            return $this->_db->first();
        }else{
            return false;
        }
    }

    public function getInStockItems($statusID){
        $this->_db->query(
            "
                SELECT 
                    t.name,
                    SUM(case when s.ID = {$statusID} then 1 else null end) as count
                FROM 
                    items i
                RIGHT JOIN item_types t ON i.itemTypeID = t.id
                LEFT JOIN item_status s ON i.statusID = s.ID
                GROUP BY t.name
                ORDER BY t.id 
            ", array());
        return $this->_db->results();
    }

    public function getLastItem(){
        $this->_db->query("SELECT * FROM items ORDER BY ID DESC", array());
        if($this->_db->count() !== 0){
            return $this->_db->first();
        }else{
            return false;
        }
    }
}