<?php

    require_once __DIR__ . '/core/ini.php';

    if(($case = Input::get('case')) && ($id = Input::get('id')) && ($noteID = Input::get('noteID'))){



        switch ($case){
        
        case 'employee':
                
                
                $note = new Note(Input::get('noteID'));
                
                $note->delete(Input::get('noteID'));
                
                $link = 'profile.php?id='.$id.'';
                
                Session::flash('home', 'Note has been deleted!');
                Session::flash('note', 'defaultOpen');
                Redirect::to($link);
                
                break;

            case 'lead':
                
                $lead = new Lead(Input::get('id'));
                $note = new Note(Input::get('noteID'));
                
                $note->delete(Input::get('noteID'));
                
                $link = 'info.php?case='.$case.'&id='.$id.'';
                
                Session::flash('home', 'Note has been deleted!');
                Session::flash('note', 'defaultOpen');
                Redirect::to($link);
                
                break;

            case 'contact':
                
                $contact = new Contact(Input::get('id'));
                $note = new Note(Input::get('noteID'));
                
                $note->delete(Input::get('noteID'));
                
                $link = 'info.php?case='.$case.'&id='.$id.'';
                
                Session::flash('home', 'Note has been deleted!');
                Session::flash('note', 'defaultOpen');
                Redirect::to($link);
                
                break;

            case 'customer':
                
                $customer = new Customer(Input::get('id'));
                $note = new Note(Input::get('noteID'));
                
                $note->delete(Input::get('noteID'));
                
                $link = 'info.php?case='.$case.'&id='.$id.'';
                
                Session::flash('home', 'Note has been deleted!');
 Session::flash('note', 'defaultOpen');
                Redirect::to($link);
                
                break;

        }



    }else{
        Redirect::to('index.php');
    }
