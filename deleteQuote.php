<?php

require_once __DIR__ . '/core/ini.php';

$user = new User();
$proposal = new ProposalAndQuotes();

if($user->isLoggedIn()) {
    if (Input::exists('post') && Input::get('id')) {

        try{

            $proposal->delete(Input::get('id'));

            echo 'deleted';

        }catch (Exception $e){
            die($e->getMessage());
        }

    }else{
        Redirect::to('index.php');
    }
}