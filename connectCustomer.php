<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

if($_REQUEST['customer'] && $_REQUEST['contactID']){

	$contact = new Contact($_REQUEST['contactID']);
	$customer = new Customer();
	
	foreach($customer->getCustomers() as $item){
		if($_REQUEST['customer'] == $item->name){
			
			try{

	                $contact->update(array(
	                    'customerID' => $item->id,
	                   
	                ),$_REQUEST['contactID']);
	                
	                echo 'Contact has been connected!';
	
	            }catch (Exception $e){
	                die($e->getMessage());
	            }
			
		}
	}
	
	

}else{
	Redirect::to(404);
}