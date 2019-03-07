<?php

    require_once __DIR__ . '/core/ini.php';

    if(($case = Input::get('case')) && ($id = Input::get('id')) || ($sku = Input::get('sku'))){



        switch ($case){

            case 'lead':
                
                $lead = new Lead(Input::get('id'));

                try{
                    $lead->delete(Input::get('id'));
                    Session::flash('home', 'Lead has been deleted!');
                    Redirect::to('leads.php');
                }catch (Exception $e){
                    die($e->getMessage());
                }

                
                break;

            case 'contact':
                
                $contact = new Contact(Input::get('id'));

                try{
                    $contact->delete(Input::get('id'));
                    Session::flash('home', 'Contact has been deleted!');
                    Redirect::to('contacts.php');
                }catch (Exception $e){
                    die($e->getMessage());
                }

                break;

            case 'customer':
                
                $customer = new Customer(Input::get('id'));

                try{
                    $customer->delete(Input::get('id'));
                    Session::flash('home', 'Customer has been deleted!');
                    Redirect::to('customers.php');
                }catch (Exception $e){
                    die($e->getMessage());
                }

                
                break;

            case 'item':

                $item = new Inventory(Input::get('id'));

                try{
                    $item->delete(Input::get('id'));
                    Session::flash('home', 'Item has been deleted!');
                    Redirect::to('inventory.php');
                }catch (Exception $e){
                    die($e->getMessage());
                }

                break;

            case 'employee':

                $employee = new User(Input::get('id'));

                try{
                    $employee->delete(Input::get('id'));
                    Session::flash('home', 'Employee has been deleted!');
                    Redirect::to('employees.php');
                }catch (Exception $e){
                    die($e->getMessage());
                }


                break;

        }



    }else{
        Redirect::to('index.php');
    }
