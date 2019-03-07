<?php

require_once __DIR__ . '/core/ini.php';

$lead = new Lead();
$contact = new Contact();
$customer = new Customer();

$i = 0;

foreach($lead->getLeads() as $lead){
	$search["lead"][$i]["name"] = $lead->prefix .' '. $lead->firstName .' '. $lead->lastName;
	$search["lead"][$i]["id"] = $lead->id;
	$i++;
}

foreach($contact->getContacts() as $contact){
	$search["contact"][$i]['name'] = $contact->prefix .' '. $contact->firstName .' '. $contact->lastName;
	$search["contact"][$i]['id'] = $contact->id;
	$i++;
}

foreach($customer->getCustomers() as $customer){
	$search["customer"][$i]['name'] = $customer->name;
	$search["customer"][$i]['id'] = $customer->id;
	$i++;
}

// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = array();

// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    
    $k = 0;
    
    foreach($search as $key => $type){
    
    	foreach($type as $data) {
        	if (stristr($data['name'], $q) !== FALSE) {
	            			$hint[$key][$k]['name'] = $data['name'];
	            			$hint[$key][$k]['id'] = $data['id'];
	            			$k++;
	            	}       
    }
    }
    
}

// Output "no suggestion" if no hint was found or output correct values 
if(empty($hint)){
	echo '<span class="search-no-item"><i class="far fa-times-circle"></i>Nothing found...</span>';
}else{

	if(isset($hint['lead'])){
		$countLead = count($hint['lead']);
	}
	
	if(isset($hint['contact'])){
		$countContact = count($hint['contact']);
	}
	
	if(isset($hint['customer'])){
		$countCustomer = count($hint['customer']);
	}
	
	foreach($hint as $key => $field){
		if($key == 'lead'){
			echo '<h4 class="search-header"><i class="far fa-dot-circle"></i>'.$key.'<span>'.$countLead.'</span></h4>';
		}elseif($key == 'contact'){
			echo '<h4 class="search-header"><i class="far fa-address-book"></i>'.$key.'<span>'.$countContact.'</span></h4>';
		}elseif($key == 'customer'){
			echo '<h4 class="search-header"><i class="fas fa-dollar-sign"></i>'.$key.'<span>'.$countCustomer.'</span></h4>';
		}
		foreach($field as $data){
			echo '<a class="search-item" style="display:block;" href="info.php?case='.$key.'&id='.$data['id'].'">' .$data['name'].'</a>';
		}
	}
}

?>