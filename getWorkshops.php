<?php

require_once __DIR__ . '/core/ini.php';

$user = new User();
$inventory = new Inventory();

if($user->isLoggedIn()) {
    if(Input::exists('get')) {

        $q = Input::get('q');

        if ($q !== "") {
            $q = strtolower($q);
            $len = strlen($q);

            $k = 0;

            foreach($inventory->getWorkshops() as $workshop){

                if (stristr($workshop->titleOfOffering, $q) !== false) {
                    if($k < 7){
                        echo "<div class='autocomplete-item' onclick='selectCustomer(this)'>".$workshop->titleOfOffering."</div>";
                        $k++;
                    }
                }


            }



        }



    }
}