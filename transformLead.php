<?php

	/*
	 * Require ini file with settings
	 */
	require_once __DIR__ . '/core/ini.php';

	$user = new User();
	
	if($user->isLoggedIn()){
		if($id = Input::get('id')){
			
			$lead = new Lead($id);
			$customer = new Customer();
			$contact = new Contact();
			$requests = new Request();
			
			if($lead->exists()){
			
				if(!$customer->checkIfExists($lead->data()->company)){
				
				$customerID = $lead->data()->id;
				$contactID = $customerID + 1;
				
					try{

                        $customer->create(array(
                        'id' => $customerID,
                            'name' => $lead->data()->company,
                            'category' => $lead->data()->category,
                            'partnerRep' => $lead->data()->partnerRep,
                            'description' => $lead->data()->description,
                            'tags' => $lead->data()->tags,
                            'partner' => $lead->data()->partner,
                            'reachedUsBy' => $lead->data()->reachedUsBy,
                            'officePhone' => $lead->data()->officePhone,
                            'phoneExt' => $lead->data()->phoneExt,
                            'mobilePhone' => $lead->data()->mobilePhone,
                            'email' => $lead->data()->email,
                            'street' => $lead->data()->street,
                            'city' => $lead->data()->city,
                            'state' => $lead->data()->state,
                            'country' => $lead->data()->country,
                            'zip' => $lead->data()->zip,
                            'followUpDescription' => $lead->data()->followUpDescription,
                            'facebook' => $lead->data()->facebook,
                            'twitter' => $lead->data()->twitter,
                            'linkedIn' => $lead->data()->linkedIn,
                            'website' => $lead->data()->website,
                            'lastContacted' => 'Not contacted',
                            'createdBy' => $user->data()->firstName.' '.$user->data()->lastName,
                            'createdOn' => date('n/j/y'),
                            'modifiedBy' => '-',
                            'modifiedOn' => '-',
                            'logo' => $lead->data()->logo
                        ));
					
						$contact->create(array(
						    'customerID' => $customerID,
                            'id' => $contactID,
                            'prefix' => $lead->data()->prefix,
                            'firstName' => $lead->data()->firstName,
                            'lastName' => $lead->data()->lastName,
                            'jobTitle' => $lead->data()->jobTitle,
                            'category' => $lead->data()->category,
                            'customer' => $lead->data()->company,
                            'description' => $lead->data()->description,
                            'tags' => $lead->data()->tags,
                            'mobilePhone' => $lead->data()->mobilePhone,
                            'phoneExt' => $lead->data()->phoneExt,
                            'officePhone' => $lead->data()->officePhone,
                            'email' => $lead->data()->email,
                            'street' => $lead->data()->street,
                            'city' => $lead->data()->city,
                            'district' => $lead->data()->district,
                            'country' => $lead->data()->country,
                            'state' => $lead->data()->state,
                            'zip' => $lead->data()->zip,
                            'followUpDate' => $lead->data()->followUpDate,
                            'followUpDescription' => $lead->data()->followUpDescription,
                            'facebook' => $lead->data()->facebook,
                            'twitter' => $lead->data()->twitter,
                            'linkedIn' => $lead->data()->linkedIn,
                            'website' => $lead->data()->website,
                            'createdBy' => $user->data()->firstName.' '.$user->data()->lastName,
                            'createdOn' => date('n/j/y'),
                            'lastContacted' => 'Not contacted',
                            'modifiedBy' => '-',
                            'modifiedOn' => '-',
                        ));

                        foreach ($requests->getLeadRequestsByID($lead->data()->id) as $request){

                            $requests->update([
                                'leadID' => null,
                                'customerID' => $customerID
                            ], $request->ID);

                        }
				                	
                        $lead->updateAdditionalInfo(array(
                            'leadID' => null,
                            'customerID' => $customerID
                        ), $lead->data()->id);
				                	
				        $lead->delete($id);        
					
					
			
                        Session::flash('home', 'Lead successfully changed!');
                        Redirect::to('contacts.php');
			
                    }catch (Exception $e){
                        die($e->getMessage());
                    }
			            
				}else{
				
				try{
				
					$contact->create(array(
                        'prefix' => $lead->data()->prefix,
                        'firstName' => $lead->data()->firstName,
                        'lastName' => $lead->data()->lastName,
                        'jobTitle' => $lead->data()->jobTitle,
                        'category' => $lead->data()->category,
                        'customer' => $lead->data()->company,
                        'description' => $lead->data()->description,
                        'tags' => $lead->data()->tags,
                        'mobilePhone' => $lead->data()->mobilePhone,
                        'phoneExt' => $lead->data()->phoneExt,
                        'officePhone' => $lead->data()->officePhone,
                        'email' => $lead->data()->email,
                        'street' => $lead->data()->street,
                        'city' => $lead->data()->city,
                        'district' => $lead->data()->district,
                        'country' => $lead->data()->country,
                        'state' => $lead->data()->state,
                        'zip' => $lead->data()->zip,
                        'followUpDate' => $lead->data()->followUpDate,
                        'followUpDescription' => $lead->data()->followUpDescription,
                        'facebook' => $lead->data()->facebook,
                        'twitter' => $lead->data()->twitter,
                        'linkedIn' => $lead->data()->linkedIn,
                        'website' => $lead->data()->website,
                        'createdBy' => $user->data()->firstName.' '.$user->data()->lastName,
                        'createdOn' => date('n/j/y'),
                        'lastContacted' => 'Not contacted',
                        'modifiedBy' => '-',
                        'modifiedOn' => '-'
                    ));

                    $lead->delete($id);

                    Session::flash('home', 'Lead successfully changed!');
                    Redirect::to('contacts.php');
			
				    }catch (Exception $e){
                        die($e->getMessage());
                    }
				}

			}else{
				Redirect::to('index.php');
			}
		}else{
			Redirect::to('index.php');
		}
	}else{
		Redirect::to('index.php');
	}