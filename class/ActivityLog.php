<?php

class ActivityLog{

    const NOTE = '<i class="activity-log-icon fas fa-sticky-note"></i>';
    const CALL = '<i class="activity-log-icon fas fa-phone"></i>';
    const REQUEST = '<i class="activity-log-icon fas fa-file-alt"></i>';
    const CREATE = '<i class="activity-log-icon fas fa-plus-circle"></i>';
    const UPDATE = '<i class="activity-log-icon fas fa-edit"></i>';
    const ASSIGN = '<i class="activity-log-icon fas fa-user-edit"></i>';
    const TRANSFORM = '<i class="activity-log-icon fas fa-dollar-sign"></i>';
    const DELETE = '<i class="activity-log-icon fas fa-trash"></i>';
    const PROPOSAL = '<i class="activity-log-icon fas fa-file-invoice-dollar"></i>';
    const QUOTE = '<i class="activity-log-icon fas fa-receipt"></i>';
    const WORKSHOP = '<i class="activity-log-icon fas fa-chalkboard-teacher"></i>';
    const STATUS = '<i class="activity-log-icon fas fa-sync-alt"></i>';
    const FOLLOWUP = '<i class="activity-log-icon fas fa-bell"></i>';
    CONST EVENT = '<i class="activity-log-icon fas fa-calendar"></i>';
    CONST ITEM = '<i class="activity-log-icon fas fa-box"></i>';

    private $_db,
        $_data;


    public function __construct($log = null){
        $this->_db = DB::getInstance();

        if($log){
            $this->find($log);
        }
    }

    public function update($fields = array(), $id = null){
        if(!$this->_db->update('activity_log', $id, $fields)){
            throw new Exception('There was a problem updating.');
        }
    }

    public function clearLog($caseID){
        if(!$this->_db->delete('activity_log', array('caseID', '=', $caseID))){
            throw new Exception('There was a problem clearing an log.');
        }
    }

    public function create($fields = array()){
        if(!$this->_db->insert('activity_log', $fields)){
            throw new Exception('There was a problem creating an log.');
        }
    }

    public function find($log = null){
        if($log){

            $data = $this->_db->get('activity_log', array('id', '=', $log));

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

    public function getActivityLog($id){
        $this->_db->query('SELECT * FROM activity_log WHERE caseID = '.$id, array());
        return $this->_db->results();
    }

    public function getActivityLogGrouped($id){
        $this->_db->query('SELECT activity_log.*, users.firstName, users.lastName FROM activity_log LEFT JOIN users ON activity_log.userID = users.id WHERE caseID = '.$id.' ORDER BY id DESC', array());

        date_default_timezone_set('America/New_York');

        $logs = [];
        if($this->_db->results()){
            foreach ($this->_db->results() as $log){

                $date = new DateTime($log->time, new DateTimeZone('UTC'));
                $date->setTimezone(new DateTimeZone('America/New_York'));

                $date = $date->format('m/d/y');

                switch ($date){

                    case date('m/d/y'):
                        $date = 'Today';
                        break;

                    case date('m/d/y',strtotime("-1 days")):
                        $date = 'Yesterday';
                        break;

                    case date('m/d/y',strtotime("-2 days")):
                        $date = date('l', strtotime($date));
                        break;

                    case date('m/d/y',strtotime("-3 days")):
                        $date = date('l', strtotime($date));
                        break;

                    default:
                        $date = date('F j, Y', strtotime($date));
                        break;
                }

                switch($log->section){
                    case 'request':
                        $icon = self::REQUEST;
                        break;
                    case 'assign':
                        $icon = self::ASSIGN;
                        break;
                    case 'call':
                        $icon = self::CALL;
                        break;
                    case 'create':
                        $icon = self::CREATE;
                        break;
                    case 'update':
                        $icon = self::UPDATE;
                        break;
                    case 'note':
                        $icon = self::NOTE;
                        break;
                    case 'status':
                        $icon = self::STATUS;
                        break;
                    case 'proposal':
                        $icon = self::PROPOSAL;
                        break;
                    case 'quote':
                        $icon = self::QUOTE;
                        break;
                    case 'workshop':
                        $icon = self::WORKSHOP;
                        break;
                    case 'delete':
                        $icon = self::DELETE;
                        break;
                    case 'transform':
                        $icon = self::TRANSFORM;
                        break;
                    case 'followup':
                        $icon = self::FOLLOWUP;
                        break;
                    case 'event':
                        $icon = self::EVENT;
                        break;
                    case 'item':
                        $icon = self::ITEM;
                        break;
                }

                $logs[$date][$log->id] = [
                    'id' => $log->id,
                    'userID' => $log->userID,
                    'userName' => $log->firstName . ' ' . $log->lastName,
                    'case' => $log->caseName,
                    'caseID' => $log->caseID,
                    'section' => $log->section,
                    'text' => $log->text,
                    'time' => $log->time,
                    'icon' => $icon
                ];

            }
        }

        return $logs;
    }

    public function getAllActivityLog(){
        $this->_db->query('SELECT * FROM activity_log ORDER BY id DESC', array());
        return $this->_db->results();
    }

    public function getBoardActivityLog(){
        $this->_db->query('
            
            SELECT
                activity_log.*, 
                users.firstName,
                users.lastName,
                company.name
            FROM
                activity_log
            LEFT JOIN users ON activity_log.userID = users.id
            LEFT JOIN (
                SELECT
                    ID,
                    company AS name
                FROM
                    leads
                UNION
                    SELECT
                        ID,
                        name
                    FROM
                        customers
                UNION
                    SELECT
                        ID,
                        CONCAT(firstName,\' \',lastName) AS name
                    FROM
                        contacts
            ) company ON company.ID = activity_log.caseID
            ORDER BY
                id DESC
            LIMIT 15
            
        ', []);
        date_default_timezone_set('America/New_York');

        $logs = [];
        if($this->_db->results()){
            foreach ($this->_db->results() as $log){

                $date = new DateTime($log->time, new DateTimeZone('UTC'));
                $date->setTimezone(new DateTimeZone('America/New_York'));

                $date = $date->format('m/d/y');

                switch ($date){

                    case date('m/d/y'):
                        $date = 'Today';
                        break;

                    case date('m/d/y',strtotime("-1 days")):
                        $date = 'Yesterday';
                        break;

                    case date('m/d/y',strtotime("-2 days")):
                        $date = date('l', strtotime($date));
                        break;

                    case date('m/d/y',strtotime("-3 days")):
                        $date = date('l', strtotime($date));
                        break;

                    default:
                        $date = date('F j, Y', strtotime($date));
                        break;
                }

                switch($log->section){
                    case 'request':
                        $icon = self::REQUEST;
                        break;
                    case 'assign':
                        $icon = self::ASSIGN;
                        break;
                    case 'call':
                        $icon = self::CALL;
                        break;
                    case 'create':
                        $icon = self::CREATE;
                        break;
                    case 'update':
                        $icon = self::UPDATE;
                        break;
                    case 'note':
                        $icon = self::NOTE;
                        break;
                    case 'status':
                        $icon = self::STATUS;
                        break;
                    case 'proposal':
                        $icon = self::PROPOSAL;
                        break;
                    case 'quote':
                        $icon = self::QUOTE;
                        break;
                    case 'workshop':
                        $icon = self::WORKSHOP;
                        break;
                    case 'delete':
                        $icon = self::DELETE;
                        break;
                    case 'transform':
                        $icon = self::TRANSFORM;
                        break;
                    case 'followup':
                        $icon = self::FOLLOWUP;
                        break;
                    case 'event':
                        $icon = self::EVENT;
                        break;
                    case 'item':
                        $icon = self::ITEM;
                        break;
                }

                $logs[$date][$log->id] = [
                    'id' => $log->id,
                    'userID' => $log->userID,
                    'userName' => $log->firstName . ' ' . $log->lastName,
                    'case' => $log->caseName,
                    'caseID' => $log->caseID,
                    'section' => $log->section,
                    'text' => $log->text,
                    'time' => $log->time,
                    'icon' => $icon,
                    'name' => $log->name
                ];

            }
        }

        return $logs;
    }
}