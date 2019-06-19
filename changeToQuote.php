<?php

require_once __DIR__ . '/core/ini.php';

if($id = Input::get('id')) {

    $proposal = new ProposalAndQuotes($id);

    try{

        $proposal->update([
            'type' => 'quote'
        ], $id);

        Redirect::to('info.php?case=customer&id='.Input::get('customerID'));

    }catch (Exception $e){
        die($e->getMessage());
    }

}