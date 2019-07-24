<?php

require_once __DIR__ . '/../../core/ini.php';

$user = new User();
$requests = new Request();

if($user->isLoggedIn()) {
    if (Input::exists()) {

        try{

            $requests->update([
                'proposalTitle' => Input::get('proposalTitle'),
                'proposalIntroduction' => Input::get('proposalIntroduction'),
                'proposalRequiredInvestment' => Input::get('proposalRequiredInvestment'),
                'presentedBy' => Input::get('proposalPresentedBy')
            ], Input::get('requestID'));

        }catch (Exception $e){
            die($e->getMessage());
        }

    }
}