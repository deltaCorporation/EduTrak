<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';
include_once __DIR__ . '/include/class/xlsxwriter.class.php';

$user = new User();
$contact = new Contact();
$writer = new XLSXWriter();

if($user->isLoggedIn()){

    $writer->writeSheetHeader('Sheet1', [
        'ID' => 'integer',
        'Prefix' => 'string',
        'First Name' => 'string',
        'Last Name' => 'string',
        'Job Title' => 'string',
        'Category' => 'string',
        'Customer' => 'string',
        'Description' => 'string',
        'Tags' => 'string',
        'Last Contacted' => 'string',
        'Office Phone' => 'string',
        'Phone Ext' => 'string',
        'Mobile Phone' => 'string',
        'Email' => 'string',
        'Street' => 'string',
        'City' => 'string',
        'District' => 'string',
        'Country' => 'string',
        'State' => 'string',
        'Zip' => 'string',
        'Follow up Date' => 'string',
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
        ]
    ]);

    foreach ($contact->getContacts() as $contact){

        $writer->writeSheetRow('Sheet1', [
            $contact->id,
            $contact->prefix,
            $contact->firstName,
            $contact->lastName,
            $contact->jobTitle,
            $contact->category,
            $contact->customer,
            $contact->description,
            $contact->tags,
            $contact->lastContacted,
            $contact->officePhone,
            $contact->phoneExt,
            $contact->mobilePhone,
            $contact->email,
            $contact->street,
            $contact->city,
            $contact->district,
            $contact->country,
            $contact->state,
            $contact->zip,
            $contact->followUpDate,
            $contact->facebook,
            $contact->twitter,
            $contact->linkedIn,
            $contact->website,
            $contact->createdBy,
            $contact->createdOn,
            $contact->modifiedBy,
            $contact->modifiedOn,
        ]);
    }

    $file = 'contacts-report.xlsx';
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

    Redirect::to('contacts.php');
}