<?php

    require_once __DIR__ . '/core/ini.php';

    $user = new User();
    $customers = new Customer();

    if($user->isLoggedIn()) {
        if(Input::exists('get')) {

            $q = Input::get('q');

            if ($q !== "") {
                $q = strtolower($q);
                $len = strlen($q);

                $k = 0;

                foreach($customers->getCustomers() as $customer){

                    if (stristr($customer->name, $q) !== false) {
                        if($k < 7){
                            echo "<div class='autocomplete-item' onclick='selectCustomer(this)'>".$customer->name."</div>";
                            $k++;
                        }
                    }


                }

            }



        }
    }