<?php

require_once __DIR__ . '/core/ini.php';

if(Input::exists()){

    $validate = new Validate();
    $validation = $validate->check($_POST, array(

    ));

    if($validation->passed()){

        $user = new User();
        $inventory = new Inventory();

        $id = date('Ymdhis');

        try{

            $inventory->create(array(
                'id' => $id,
                'eduscapeSKU' => Input::get('eduscapeSKU'),
                'workshopGroups' => Input::get('workshopGroup'),
                'track' => Input::get('track'),
                'format' => Input::get('format'),
                'time' => Input::get('timeH'),
                'audience' => Input::get('audience'),
                'titleOfOffering' => Input::get('titleOfOffering'),
                'description' => Input::get('description'),
                'learnerOutcomes' => Input::get('learnerOutcomes'),
                'prerequisites' => Input::get('prerequisites'),
                'toolbox' => Input::get('toolbox'),
                'notes' => Input::get('notes'),
                'msrp' => Input::get('MSRP'),
                'map' => Input::get('MAP'),
                'clientCost' => Input::get('clientCost'),
                'status' => Input::get('status'),
                'lastUpdate' => Input::get('lastUpdate'),
                'author' => Input::get('author'),
                'materials' => Input::get('materials'),
            ));

            Session::flash('home', 'New Inventory has been created!');
            Redirect::to('inventory.php');

        }catch (Exception $e){
            die($e->getMessage());
        }

    }


}else{
    Redirect::to(404);
}