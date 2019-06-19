<?php

use Mpdf\Mpdf;

require_once __DIR__ . '/core/ini.php';
require_once __DIR__ . '/vendor/autoload.php';

if(Input::get('id')){

    $quote = new ProposalAndQuotes(Input::get('id'));
    $customer = new Customer($quote->data()->customerID);
    $user = new User($quote->data()->userID);


    $data = $quote->getDetails(Input::get('id'));

    $total = 0;

//    var_dump($data);die;

    $mpdf = new Mpdf([
        'format' => 'Letter'
    ]);

    $mpdf->use_kwt = true;    // Default: false

    $html = '

    <style media="print">
       header{
            height: 50px;
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
            border: 1px solid black;
            border-right: none;
            border-bottom: none;
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
            margin-top: 20px;
            width: 33%;
            border: 1px solid black;
            font-family: Arial, sans-serif;
            font-size: 9pt;
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

    <header>
        <img width="33%" src="view/img/Eduscape.png">
    </header>
    <section class="content">
        <div class="address-1">
            <div>28 West Grand Avenue, Suite 5</div>
            <div>Montvale, NJ 07645</div>
            <div>Phone: 201.497.6621 Fax: 201.425.2000</div>
        </div>
        <div class="address-2">
            <b>To:</b>
            <div>'.$customer->data()->name.'</div>
            <div>'.$customer->data()->street.'</div>
            <div>'.$customer->data()->city.'</div>
            <div>'.$customer->data()->state.' '.$customer->data()->zip.'</div>
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



    foreach ($data as $item){

        $html .= '<tr>';
        $html .= '<td colspan="2" class="table-text">';
        $html .= '<h3>'.$item->workshopTitle.'</h3>';
        $html .= '<br>';
        $html .= '<h4>Description</h4>';
        $html .= '<pre>'.$item->workshopDescription.'</pre>';
        $html .= '<br>';
        $html .= '<h4>Learner Outcomes</h4>';
        $html .= '<pre>'.$item->workshopLearnerOutcomes.'</pre>';
        $html .= '<br>';
        $html .= '<h4>Prerequisites</h4>';
        $html .= '<pre>'.$item->workshopPrerequisites.'</pre>';
        $html .= '</td>';
        $html .= '<td class="align-top align-center">$'.number_format((int)$item->workshopPrice, 2).'</td>';
        $html .= '</tr>';

        $total += (int)$item->workshopPrice;
    }

                   
                   
     $html .=      '
            <tr class="table-header">
                <td  style="padding: 10px" align="right" colspan="2" class="align-center">TOTAL DUE :</td>
                <td class="align-center">$'.number_format($total, 2).'</td>
            </tr>
        </table>
    </section>
    <footer>
        <div class="yellow">Please make purchase order to:</div>
        <div class="yellow">Eduscape Partners LLC</div>
        <div>28 West Grand Avenue, Suite 5</div>
        <div>Montvale, NJ 07645</div>
    </footer>
';

    $fileName = str_replace(' ', '_', $customer->data()->name) . '_Quote_' . date('m_d_Y');
    $mpdf->SetTitle($fileName);
    $mpdf->WriteHTML($html);
    $mpdf->Output($fileName.'.pdf', 'D');
}


