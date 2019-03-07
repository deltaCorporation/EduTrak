<?php

require_once __DIR__ . '/core/ini.php';

$user = new User();
$users = new User();

if($user->isLoggedIn()) {
    if(Input::exists('get')) {

        $q = Input::get('q');

        if ($q !== "") {
            $q = strtolower($q);
            $len = strlen($q);

            $k = 0;

            foreach($users->getUsers() as $item){

                $name = $item->firstName . ' ' . $item->lastName;

                if (stristr($name, $q) !== false) {
                    if($k < 7){
                        echo "<div class='autocomplete-item' onclick='selectUser(this)'>".$name."</div>";
                        $k++;
                    }
                }


            }



        }



    }
}