<?php

use Mpdf\Mpdf;

require_once __DIR__ . '/core/ini.php';
require_once __DIR__ . '/vendor/autoload.php';

if(Input::get('id')){

    $request = new Request(Input::get('id'));
    $user = new User();

    if(Input::get('case') === 'lead'){
        $client = new Lead($request->data()->leadID);
    }else{
        $client = new Customer($request->data()->customerID);
    }

    if($request->data()->requisitioner){
        $user = new User((int)$request->data()->requisitioner);
    }

    $clientName = Input::get('case') === 'lead' ? $client->data()->company : $client->data()->name;

    $total = 0;

//    var_dump($data);die;

    $mpdf = new Mpdf([
        'format' => 'Letter'
    ]);

    $mpdf->use_kwt = true;    // Default: false
    $mpdf->shrink_tables_to_fit = 1;

    $html = '

    <style media="print">
        h1{
            color: grey;
            font-family: Arial, sans-serif;
            font-size: 17pt;
        }
        h3{
            font-family: Arial, sans-serif;
            font-size: 12pt;
        }
        p{
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }
       .header{
            border: none !important;
            height: 50px;
       }
       .header tr,
       .header tr td{
            border: none;
       }
       .address-1{
            margin-top: 20px;
            font-family: Arial, sans-serif;
            font-size: 9pt;
       }
       .address-2{
            margin-top: 20px;
            font-family: Arial, sans-serif;
            font-size: 9pt;
       }
       table{
            border-right: 1px solid black;
            border-bottom: 1px solid black;
            margin-top: 10px;
            width: 100%;
       }
       
       table tr td{
            border: .5px solid black;
            border-right: none;
            font-family: Arial, sans-serif;
            font-size: 9pt;
       }
       .table-header td{
            font-weight: bold;
            text-align: center;
       }
       .table-space{
            padding: 10px;
       }
       .table-text{
            padding: 10px;
            text-align: left !important;
       }
       .align-center{
            text-align: center;
       }
       pre{
            font-family: Arial, sans-serif;
            font-size: 9pt;
       }
       footer{
            margin-top: 0;
            width: 33%;
            border: 1px solid black;
            font-family: Arial, sans-serif;
            font-size: 9pt;
            page-break-inside: avoid
       }
       footer div{
            padding: 2px;
       }
       .yellow{
            background-color: yellow;
       }
       h4{
            
       }
        
    </style>   
    <table class="header" cellspacing="0" cellpadding="0">
        <tr>
            <td><img width="33%" src="view/img/Eduscape.png"></td>
            <td align="right"><h1>QUOTE</h1></td>
        </tr>
    </table>
    <section class="content">
        <div class="address-1">
            <div>28 West Grand Avenue, Suite 5</div>
            <div>Montvale, NJ 07645</div>
            <div>Phone: 201.497.6621 Fax: 201.425.2000</div>
        </div>
        <div class="address-2">
            <b>To:</b>
            <div>'.$clientName.'</div>
            <div>'.$client->data()->street.'</div>
            <div>'.$client->data()->city.'</div>
            <div>'.$client->data()->state.' '.$client->data()->zip.'</div>
        </div>
        <table cellspacing="0">
            <tr class="table-header">
                <td>Date</td>
                <td>Requisitioner</td>
                <td>Due Date</td>
            </tr>
            <tr>
                <td class="align-center">'.date('m/d/Y').'</td>
                <td class="align-center">'.$user->data()->firstName.' '.$user->data()->lastName.'</td>
                <td class="align-center">net 30</td>
            </tr>
            <tr>
                <td class="table-space" colspan="2"></td>
                <td class="table-space"></td>
            </tr>
            <tr class="table-header">
                <td colspan="2">DESCRIPTION</td>
                <td>TOTAL</td>
            </tr>
                 ';

    foreach ($request->getRequestWorkshopsByID($request->data()->ID) as $workshop){

        $html .= '<tr>';
        $html .= '<td colspan="2" class="table-text">';
        $html .= '<h3>'.$workshop->workshopTitle.'</h3>';
        $html .= '<br>';
        $html .= '<h4>Description</h4>';
        $html .= '<pre>'.$workshop->workshopDescription.'</pre>';
        $html .= '<br>';
        $html .= '<h4>Learner Outcomes</h4>';
        $html .= '<pre>'.$workshop->workshopLearnerOutcomes.'</pre>';
        $html .= '</td>';
        $html .= '<td class="align-top align-center">$'.number_format((int)$workshop->workshopPrice, 2).'</td>';
        $html .= '</tr>';

        $total += (int)$workshop->workshopPrice;
    }


                   
     $html .=      '
            <tr class="table-header">
                <td  style="padding: 10px" align="right" colspan="2" class="align-center">TOTAL DUE :</td>
                <td class="align-center">$'.number_format($total, 2).'</td>
            </tr>
        </table>
    </section>
    <p>Quote valid for 30 days</p>
    <footer>
        <div class="yellow">Please make purchase order to:</div>
        <div class="yellow">Eduscape Partners LLC</div>
        <div>28 West Grand Avenue, Suite 5</div>
        <div>Montvale, NJ 07645</div>
    </footer>
';

    $fileName = str_replace(' ', '_', $clientName) . '_Quote_' . date('m_d_Y');
    $mpdf->SetTitle($fileName);
    $mpdf->WriteHTML($html);

    if(Input::get('type') === 'preview'){
        $type = 'I';
    }else{
        $type = 'D';
    }

    $mpdf->Output($fileName.'.pdf', $type);
}


