<?php

require_once __DIR__ . '/core/ini.php';

if(Input::exists()){


    $validate = new Validate();
    $validation = $validate->check($_POST, array(

    ));

    if($validation->passed()){

        $user = new User();
        $inventory = new Inventory(Input::get('id'));

        try{

            $inventory->update(array(
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
            ),Input::get('id'));



            Session::flash('home', 'Inventory has been updated!');
            Redirect::to('item.php?id='.Input::get('id'));

        }catch (Exception $e){
            die($e->getMessage());
        }

    }


}else{
    Redirect::to(404);
}
