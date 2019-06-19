<?php

use Mpdf\Mpdf;

require_once __DIR__ . '/core/ini.php';
require_once __DIR__ . '/vendor/autoload.php';

if(Input::get('id')){

    $proposal = new ProposalAndQuotes(Input::get('id'));
    $customer = new Customer($proposal->data()->customerID);
    $user = new User($proposal->data()->userID);


    $data = $proposal->getDetails(Input::get('id'));

//    var_dump($proposal->data(), $customer->data(), $user->data(), $data);die;

    $total = 0;

//    var_dump($data);die;

    $mpdf = new Mpdf([
        'format' => 'Letter'
    ]);

    $mpdf->use_kwt = true;    // Default: false

    $fileName = str_replace(' ', '_', $customer->data()->name) . '_Proposal_' . date('m_d_Y');
    $mpdf->SetTitle($fileName);

    $style = "
    
        <style>
        
            h1{
                font-size: 33px;
                line-height: 1px;
                font-family: Arial, sans-serif;
                text-align: center;
            }
            
            h3{
                font-family: Arial, sans-serif;
                text-align: center;
            }
            
            #logo-wrapper{
                text-align: center;
            }
            
            #logo{
                width: 200px;
            }
            
            #title-wrapper{
                text-align: center;
            }
            
            #title{
                font-size: 25px;
                font-weight: bold;
                font-family: Arial, sans-serif;
                width: 50%;
            }
            
            #presented-by span{
                font-size: 15px;
                font-family: Arial, sans-serif;
            }
            
            #powered-by-wrapper{
                border: 1px solid red;
            }
            
            #powered-by{
                float: right;
            }
            
        </style>
    
    ";

    $mpdf->WriteHTML($style);

    $html = "
    
        <br><br><br><br><br><br><br><br><br><br>
        <h1>PROFESSIONAL DEVELOPMENT</h1>
        <h1>PROPOSAL</h1>
        
        <br><br>
        <h3>PREPARED FOR</h3>
        <br>
        
        <div id='logo-wrapper'>
            <img id='logo' src='view/img/logos/".$customer->data()->logo."'>
        </div>
        
        <br>
        <h3>".date('F d, Y')."</h3>
        
        <br>
        <div id='title-wrapper'>
            <span id='title'>".$proposal->data()->title."</span>
        </div>
        
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br>
        
        <div>
            <div id='presented-by'>
                <span>PRESENTED BY</span><br>
                <span>".$user->data()->firstName ." ". $user->data()->lastName . ", " . $user->data()->title ."</span><br>
                <span>". $user->data()->email ."</span><br>
                <span>M. ". $user->data()->phone ."</span><br>
            </div>
        </div>
        
        
    
    ";

    $mpdf->WriteHTML($html);
    $mpdf->Output($fileName.'.pdf', 'D');
}


