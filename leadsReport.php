<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';
include_once __DIR__ . '/include/class/xlsxwriter.class.php';

$user = new User();
$lead = new Lead();
$writer = new XLSXWriter();

if($user->isLoggedIn()){

    $writer->writeSheetHeader('Sheet1', [
        'ID' => 'integer',
        'Prefix' => 'string',
        'First Name' => 'string',
        'Last Name' => 'string',
        'Job Title' => 'string',
        'Category' => 'string',
        'Company' => 'string',
        'Reached Us By' => 'string',
        'Partner' => 'string',
        'Partner Rep' => 'string',
        'Assigned To' => 'string',
        'Description' => 'string',
        'Tags' => 'string',
        'Last Contacted' => 'string',
        'Follow Up Date' => 'string',
        'Office Phone' => 'string',
        'Phone Ext' => 'string',
        'Mobile Phone' => 'string',
        'Email' => 'string',
        'Street' => 'string',
        'City' => 'string',
        'Country' => 'string',
        'State' => 'string',
        'Zip' => 'string',
        'Facebook' => 'string',
        'Twitter' => 'string',
        'LinkedIn' => 'string',
        'Website' => 'string',
        'Modified By' => 'string',
        'Modified On' => 'string',
        'Created By' => 'string',
        'Created On' => 'string'
    ], [
        'widths' => [
            20,
            10,
            25,
            25,
            60,
            20,
            60,
            15,
            30,
            30,
            30,
            100,
            50,
            15,
            15,
            15,
            10,
            15,
            50,
            50,
            25,
            15,
            20,
            10,
            20,
            20,
            20,
            20,
            20,
            15,
            20,
            15
        ]
    ]);

    foreach ($lead->getLeads() as $lead){

        $writer->writeSheetRow('Sheet1', [
            $lead->id,
            $lead->prefix,
            $lead->firstName,
            $lead->lastName,
            $lead->jobTitle,
            $lead->category,
            $lead->company,
            $lead->reachedUsBy,
            $lead->partner,
            $lead->partnerRep,
            $lead->assignedTo,
            $lead->description,
            $lead->tags,
            $lead->lastContacted,
            $lead->followUpDate,
            $lead->officePhone,
            $lead->phoneExt,
            $lead->mobilePhone,
            $lead->email,
            $lead->street,
            $lead->city,
            $lead->country,
            $lead->state,
            $lead->zip,
            $lead->facebook,
            $lead->twitter,
            $lead->linkedIn,
            $lead->website,
            $lead->modifiedBy,
            $lead->modifiedOn,
            $lead->createdBy,
            $lead->createdOn,
        ]);
    }

    $file = 'leads-report.xlsx';
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

    Redirect::to('leads.php');
}