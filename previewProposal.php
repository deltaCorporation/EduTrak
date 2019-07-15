<?php

use Mpdf\Mpdf;

require_once __DIR__ . '/core/ini.php';
require_once __DIR__ . '/vendor/autoload.php';

if(Input::get('id')){

    $customer = new Customer(Input::get('id'));
    $user = new User(Input::get('user'));

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
            
            #investments h4,
            #introduction h4,
            #workshops h4{
                font-size: 15px;
                font-family: Arial, sans-serif;
            }
            
            #investments p,
            #introduction p,
            #workshops p{
                font-size: 13px;
                font-family: Arial, sans-serif;
            }
            
            #workshops h5{
                font-size: 13px;
                font-family: Arial, sans-serif;
                padding: 4px;
                background-color: rgba(0,0,0,.1);
            }
            
            #workshops h6{
                font-size: 13px;
                font-family: Arial, sans-serif;
            }
            
            .learner-outcomes{
                padding: 0 20px;
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
            <span id='title'>".Input::get('title')."</span>
        </div>
        
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br>
        
        <div>
            <div id='presented-by'>
                <span>PRESENTED BY</span><br>
                <span>".$user->data()->firstName ." ". $user->data()->lastName . ", " . $user->data()->role ."</span><br>
                <span>". $user->data()->email ."</span><br>
                <span>M. ". $user->data()->phone ."</span><br>
            </div>
        </div>
    ";

    // Introduction

    $mpdf->WriteHTML($html);
    $mpdf->AddPage();

    $html = "
        <div id='introduction'>
            <h4>INTRODUCTION</h4>
            <p>". nl2br(Input::get('introduction'))."</p>
        </div>
    ";

    $mpdf->WriteHTML($html);

    // Workshops

    $data = Input::get('data');
    $mpdf->AddPage();

    $html = "
        <div id='workshops'>
            <h4>Workshop Descriptions</h4>
            ";

    foreach ($data as $workshop){

        if($workshop['learnerOutcomes'] !== ''){
            $learnerOutcomesTitle = '<h6>Learner Outcomes</h6>';
        }

        $html .= "
            <h5>".$workshop['title']."</h5>  
            <p>".nl2br($workshop['description'])."</p>  
            
            ".$learnerOutcomesTitle."
            <p class='learner-outcomes'>".nl2br($workshop['learnerOutcomes'])."</p>
        ";

    }

    $html .= "
        </div>
    ";

    $mpdf->WriteHTML($html);

    // Required Investment

    $mpdf->AddPage();

    $html = "
        <div id='investments'>
            <h4>Required Investment</h4>
            <p>". nl2br(Input::get('requiredInvestment'))."</p>
        </div>
    ";

    $mpdf->WriteHTML($html);

    $mpdf->Output($fileName.'.pdf', 'I');
}


