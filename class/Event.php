<?php

class Event{

    private $_db,
            $_data,
            $_event;


    public function __construct($event = null){
        $this->_db = DB::getInstance();

        if($event){
            $this->find($event);
        }
    }

    public function update($fields = array(), $id = null){
        if(!$this->_db->update('events', $id, $fields)){
            throw new Exception('There was a problem updating an event!');
        }

    }

    public function create($fields = array()){
        if(!$this->_db->insert('events', $fields)){
            throw new Exception('There was a problem creating an event!');
        }
    }

    public function addInstructors($fields = array()){
        if(!$this->_db->insert('event_instructors', $fields)){
            throw new Exception('There was a problem adding instructors!');
        }
    }

    public function deleteInstructors($id){
        if(!$this->_db->delete('event_instructors', array('id', '=', $id))){
            throw new Exception('There was a problem deleting an instructor.');
        }
    }

    public function delete($event){
        if(!$this->_db->delete('events', array('id', '=', $event))){
            throw new Exception('There was a problem deleting an event.');
        }
    }

    public function find($event = null){
        if($event){

            $data = $this->_db->get('events', array('id', '=', $event));

            if($data->count()){
                $this->_data = $data->first();

                return true;
            }
        }
        return false;
    }

    public function getEvents(){
        $this->_event = $this->_db->query('SELECT events.id, events.workshopTitle, events.date, events.statusID, event_status.status, events.attendeesNumber, events.linkToAsanaTask, events.customerID, customers.name FROM events INNER JOIN customers ON events.customerId = customers.id INNER JOIN event_status ON events.statusID = event_status.id ORDER  BY events.id DESC');

        return $this->_db->results();
    }

    public function getUpcomingEvents(){
        $this->_event = $this->_db->query('SELECT events.id, events.workshopTitle, events.date, events.statusID, event_status.status, events.attendeesNumber, events.linkToAsanaTask, events.customerID, customers.name FROM events INNER JOIN customers ON events.customerId = customers.id INNER JOIN event_status ON events.statusID = event_status.id ORDER  BY events.date');

        return $this->_db->results();
    }

    public function getInstructors($eventID){
        $this->_event = $this->_db->query('SELECT event_instructors.id, event_instructors.eventID, users.firstName, users.lastName FROM event_instructors INNER JOIN users ON event_instructors.userID = users.id WHERE event_instructors.eventID = ' . $eventID);
        return $this->_db->results();
    }

    public function getStatuses(){
        $this->_event = $this->_db->query('SELECT * FROM event_status');
        return $this->_db->results();
    }

    public function exists(){
        return (!empty($this->_data)) ? true : false;
    }

    public function data(){
        return $this->_data;
    }

}