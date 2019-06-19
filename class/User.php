<?php

class User{
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn,
            $_users,
            $_usersWithPermission;

    public function __construct($user = null){
        $this->_db = DB::getInstance();

        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if(!$user){
            if(Session::exists($this->_sessionName)){
                $user = Session::get($this->_sessionName);

                if($this->find($user)){
                    $this->_isLoggedIn = true;
                }else{
                    //Process to logout
                }
            }
        }else{
            $this->find($user);
        }

    }

    public function update($fields = array(), $id = null){

        if(!$this->_db->update('users', $id, $fields)){
            throw new Exception('There was a problem updating.');
        }

    }

    public function delete($user){
        if(!$this->_db->delete('users', array('id', '=', $user))){
            throw new Exception('There was a problem deleting an user.');
        }
    }

    public function create($fields = array()){
        if(!$this->_db->insert('users', $fields)){
            throw new Exception('There was a problem creating an user.');
        }
    }

    public function createPermission($fields = array()){
        if(!$this->_db->insert('user_groups', $fields)){
            throw new Exception('There was a problem creating an permission.');
        }
    }

    public function find($user = null){
        if($user){
            $field = (is_numeric($user) ? 'id' : 'email');
            $data = $this->_db->get('users', array($field, '=', $user));

            if($data->count()){
                $this->_data = $data->first();

                return true;
            }
        }
        return false;
    }

    public function login($email = null, $password = null, $remember = false){

        if(!$email && !$password && $this->exists()){
            Session::put($this->_sessionName, $this->data()->id);
        }else{
            $user = $this->find($email);

            if ($user) {
                if ($this->data()->password === Hash::make($password, $this->data()->salt)){
                    Session::put($this->_sessionName, $this->data()->id);

                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

                        if (!$hashCheck->count()) {
                            $this->_db->insert('users_session', array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_time'));
                    }

                    return true;
                }
            }

            }
            return false;
    }

    public function hasPermission($key){
        $group = $this->_db->query('SELECT * FROM user_groups INNER JOIN groups on groups.id = user_groups.groupID WHERE user_groups.userID = '.$this->data()->id, array());

        if($group->count()){
            foreach ($group->results() as $permission){
                if($permission->name == $key){
                    return true;
                }
            }
        }
        return false;
    }

    public function getUsersPermissions(){
        $this->_usersWithPermission = $this->_db->query('SELECT users.firstName, users.lastName, users.id, groups.name AS permission FROM user_groups INNER JOIN groups on groups.id = user_groups.groupID INNER JOIN users ON user_groups.userID = users.id', array());
        return $this->_db->results();
    }

    public function getUserTravelInfo($userID){
        $this->_db->query('SELECT * FROM travel_info WHERE userID = '.$userID, array());
        return$this->_db->results();
    }

    public function updateUserTravelInfo($fields = array(), $id = null){
        if(!$this->_db->update('travel_info', $id, $fields)){
            throw new Exception('There was a problem updating.');
        }
    }

    public function createUserTravelInfo($fields = array()){
        if(!$this->_db->insert('travel_info', $fields)){
            throw new Exception('There was a problem creating an user.');
        }
    }

    public function exists(){
        return (!empty($this->_data)) ? true : false;
    }
    
    public function getUsers(){
        $this->_users = $this->_db->get('users', array());

        return $this->_db->results();
    }

    public function getUserByID($userID){
        $this->_db->query('SELECT * FROM `users` WHERE id = '.$userID, array());
        var_dump($this->_db->results());die;
    }

    public function logOut(){

        $this->_db->delete('users_session', array('user_id', '=', $this->data()->id));

        Cookie::delete($this->_cookieName);
        Session::delete($this->_sessionName);
    }

    public function clearSession(){
        setcookie("PHPSESSID", "", time() - 3600);
    }

    public function data(){
        return $this->_data;
    }

    public function isLoggedIn(){
        return $this->_isLoggedIn;
    }


}