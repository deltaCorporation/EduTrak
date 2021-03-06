<?php

use Mpdf\Mpdf;

require_once __DIR__ . '/core/ini.php';
require_once __DIR__ . '/vendor/autoload.php';

$user = new User();

if($user->isLoggedIn()) {
    if (Input::get('id')) {

        $request = new Request(Input::get('id'));

        if (Input::get('case') === 'lead') {
            $client = new Lead($request->data()->leadID);
        } else {
            $client = new Customer($request->data()->customerID);
        }

        if ($request->data()->presentedBy) {
            $user = new User((int)$request->data()->presentedBy);
        }

        //    var_dump($proposal->data(), $client->data(), $user->data(), $data);die;

        $total = 0;

//    var_dump($data);die;

        $mpdf = new Mpdf([
            'format' => 'Letter'
        ]);

        $mpdf->use_kwt = true;    // Default: false

        $clientName = Input::get('case') === 'lead' ? $client->data()->company : $client->data()->name;

        $fileName = str_replace(' ', '_', $clientName) . '_Proposal_' . date('m_d_Y');
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
            <img id='logo' src='view/img/logos/" . $client->data()->logo . "'>
        </div>
        
        <br>
        <h3>" . date('F d, Y') . "</h3>
        
        <br>
        <div id='title-wrapper'>
            <span id='title'>" . $request->data()->proposalTitle . "</span>
        </div>
        
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br>
        
        <div>
            <div id='presented-by'>
                <span>PRESENTED BY</span><br>
                <span>" . $user->data()->firstName . " " . $user->data()->lastName . ", " . $user->data()->role . "</span><br>
                <span>" . $user->data()->email . "</span><br>
                <span>M. " . $user->data()->phone . "</span><br>
            </div>
        </div>
    ";

        // Introduction

        $mpdf->WriteHTML($html);
        $mpdf->AddPage();

        $html = "
        <div id='introduction'>
            <h4>INTRODUCTION</h4>
            <p>" . nl2br($request->data()->proposalIntroduction) . "</p>
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

        foreach ($request->getRequestWorkshopsByID($request->data()->ID) as $workshop) {

            if ($workshop->workshopLearnerOutcomes !== '') {
                $learnerOutcomesTitle = '<h6>Learner Outcomes</h6>';
            } else {
                $learnerOutcomesTitle = '';

            }

            $html .= "
            <h5>" . $workshop->workshopTitle . "</h5>  
            <p>" . nl2br($workshop->workshopDescription) . "</p>  
            
            " . $learnerOutcomesTitle . "
            <p class='learner-outcomes'>" . nl2br($workshop->workshopLearnerOutcomes) . "</p>
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
            <p>" . nl2br($request->data()->proposalRequiredInvestment) . "</p>
        </div>
    ";

        $mpdf->WriteHTML($html);

        if (Input::get('type') === 'preview') {
            $type = 'I';
        } else {
            $type = 'D';
        }

        $mpdf->Output($fileName . '.pdf', $type);
    }
}else{
    Redirect::to('index.php');
}


