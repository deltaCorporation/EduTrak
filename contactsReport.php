<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();
$contact = new Contact();

if($user->isLoggedIn()){

    try{

        $fileName = 'contacts-report';

        // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$fileName.'.csv');

        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        $csvHeader = array(
            'ID',
            'Prefix',
            'First Name',
            'Last Name',
            'Job Title',
            'Category',
            'Customer',
            'Description',
            'Tags',
            'Last Contacted',
            'Office Phone',
            'Phone Ext',
            'Mobile Phone',
            'Email',
            'Street',
            'City',
            'District',
            'Country',
            'State',
            'Zip',
            'Follow up Date',
            'Facebook',
            'Twitter',
            'LinkedIn',
            'Website',
            'Created By',
            'Created On',
            'Modified By',
            'Modified On'
        );

        fputcsv($output, $csvHeader);

        foreach ($contact->getContacts() as $contact){

            $data = array();


            $data['id'] = $contact->id;
            $data['prefix'] = $contact->prefix;
            $data['firstName'] = $contact->firstName;
            $data['lastName'] = $contact->lastName;
            $data['jobTitle'] = $contact->jobTitle;
            $data['category'] = $contact->category;
            $data['customer'] = $contact->customer;
            $data['description'] = $contact->description;
            $data['tags'] = $contact->tags;
            $data['lastContacted'] = $contact->lastContacted;
            $data['officePhone'] = $contact->officePhone;
            $data['phoneExt'] = $contact->phoneExt;
            $data['mobilePhone'] = $contact->mobilePhone;
            $data['email'] = $contact->email;
            $data['street'] = $contact->street;
            $data['city'] = $contact->city;
            $data['district'] = $contact->district;
            $data['country'] = $contact->country;
            $data['state'] = $contact->state;
            $data['zip'] = $contact->zip;
            $data['followUpDate'] = $contact->followUpDate;
            $data['facebook'] = $contact->facebook;
            $data['twitter'] = $contact->twitter;
            $data['linkedIn'] = $contact->linkedIn;
            $data['website'] = $contact->website;
            $data['createdBy'] = $contact->createdBy;
            $data['createdOn'] = $contact->createdOn;
            $data['modifiedBy'] = $contact->modifiedBy;
            $data['modifiedOn'] = $contact->modifiedOn;


            fputcsv($output, $data);
        }

        fclose($output);


    }catch(Exception $e) {
        die($e->getMessage());
    }


}