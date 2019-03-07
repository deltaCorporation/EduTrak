<?php

require_once __DIR__ . '/core/ini.php';

if(Input::exists()){
    

        $validate = new Validate();
        $validation = $validate->check($_POST, array(

        ));

        if($validation->passed()){

            $note = new Note();

$redirectLink = 'info.php?case='.Input::get('case').'&id='.Input::get('id').'';

            try{

                $note->update(array(
                    'title' => Input::get('noteTitle'),
                    'content' => Input::get('noteContent'),
                ),Input::get('noteID'));

		

                Session::flash('home', 'Note has been updated!');
                Session::flash('note', 'defaultOpen');

            Redirect::to($redirectLink);

            }catch (Exception $e){
                die($e->getMessage());
            }

        }

    
}else{
    Redirect::to(404);
}