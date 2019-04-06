<?php

	require_once __DIR__ . '/core/ini.php';
	
	$user = new User();
	
	if($user->isLoggedIn()){
		if(Input::exists('post')){
		
			$ntfs = new Notification();

			if(Input::get('type')){

                foreach ($ntfs->getNotifications() as $ntf) {

                    if ($ntf->userID == $user->data()->id) {

                        if ($ntf->seen == 0) {

                            try {

                                $ntfs->update(array(
                                    'seen' => 1
                                ), $ntf->id);

                            }catch (Exception $e){
                                die($e->getMessage());
                            }
                        }
                    }
                }

            }else{
                try{

                    $ntfs->update(array(
                        'seen' => 1
                    ), Input::get('id'));

                }catch (Exception $e){
                    die($e->getMessage());
                }
            }
		}
	}
	
	