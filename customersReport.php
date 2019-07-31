<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';
include_once __DIR__ . '/include/class/xlsxwriter.class.php';

$user = new User();
$customer = new Customer();
$writer = new XLSXWriter();

if($user->isLoggedIn()){

    $writer->writeSheetHeader('Sheet1', [
        'ID' => 'integer',
        'Name' => 'string',
        'Category' => 'string',
        'Partner Rep' => 'string',
        'Reached Us By' => 'string',
        'Description' => 'string',
        'Tags' => 'string',
        'Last Contacted' => 'string',
        'Partner' => 'string',
        'Parent Customer' => 'string',
        'Office Phone' => 'string',
        'Phone Ext' => 'string',
        'Mobile Phone' => 'string',
        'Email' => 'string',
        'Fax' => 'string',
        'Accounts Payable Info' => 'string',
        'Street' => 'string',
        'City' => 'string',
        'State' => 'string',
        'Country' => 'string',
        'Zip' => 'string',
        'FollowUp Date' => 'string',
        'Facebook' => 'string',
        'Twitter' => 'string',
        'LinkedIn' => 'string',
        'Website' => 'string',
        'Created By' => 'string',
        'Created On' => 'string',
        'Modified By' => 'string',
        'Modified On' => 'string'

    ], [
        'widths' => [
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
            30,
        ]
    ]);

    foreach ($customer->getCustomers() as $customer){

        $writer->writeSheetRow('Sheet1', [
            $customer->id,
            $customer->name,
            $customer->category,
            $customer->partnerRep,
            $customer->reachedUsBy,
            $customer->description,
            $customer->tags,
            $customer->lastContacted,
            $customer->partner,
            $customer->parentCustomer,
            $customer->officePhone,
            $customer->phoneExt,
            $customer->mobilePhone,
            $customer->email,
            $customer->fax,
            $customer->accountsPayableInfo,
            $customer->street,
            $customer->city,
            $customer->state,
            $customer->country,
            $customer->zip,
            $customer->followUpDate,
            $customer->facebook,
            $customer->twitter,
            $customer->linkedIn,
            $customer->website,
            $customer->createdBy,
            $customer->createdOn,
            $customer->modifiedBy,
            $customer->modifiedOn,
        ]);
    }

    $file = 'customers-report.xlsx';
    $writer->writeToFile($file);

    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        unlink($file);
    }

    Redirect::to('customers.php');
}