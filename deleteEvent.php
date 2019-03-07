<?php

	require_once __DIR__ . '/core/ini.php';
	
	$user = new User();
	
	if($user->isLoggedIn()){
		if(Input::exists('get')){
		
			$event = new Event();
		
			try{
				$event->delete(Input::get('id'));    
	               
			}catch (Exception $e){
                		die($e->getMessage());
            		}
		}
	}
	
	