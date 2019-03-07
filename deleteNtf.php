<?php

	require_once __DIR__ . '/core/ini.php';
	
	$user = new User();
	
	if($user->isLoggedIn()){
		if(Input::exists('get')){
		
			$ntf = new Notification();
	

	try{
	
	$ntf->update(array(
		'seen' => 1
	), Input::get('id'));
	
	}catch (Exception $e){
                die($e->getMessage());
        }
		}
	}
	
	