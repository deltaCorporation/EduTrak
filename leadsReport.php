<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();
$lead = new Lead();

if($user->isLoggedIn()){

    try{

        $fileName = 'leads-report';

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
            'Company',
            'Reached Us By',
            'Partner',
            'Partner Rep',
            'Assigned To',
            'Description',
            'Tags',
            'Last Contacted',
            'Follow Up Date',
            'Office Phone',
            'Phone Ext',
            'Mobile Phone',
            'Email',
            'Street',
            'City',
            'Country',
            'State',
            'Zip',
            'Facebook',
            'Twitter',
            'LinkedIn',
            'Website',
            'Modified By',
            'Modified On',
            'Created By',
            'Created On'
        );

        fputcsv($output, $csvHeader);

        foreach ($lead->getLeads() as $lead){

            $data = array();


                $data['id'] = $lead->id;
                $data['prefix'] = $lead->prefix;
                $data['firstName'] = $lead->firstName;
                $data['lastName'] = $lead->lastName;
                $data['jobTitle'] = $lead->jobTitle;
                $data['category'] = $lead->category;
                $data['company'] = $lead->company;
                $data['reachedUsBy'] = $lead->reachedUsBy;
                $data['partner'] = $lead->partner;
                $data['partnerRep'] = $lead->partnerRep;
                $data['assignedTo'] = $lead->assignedTo;
                $data['description'] = $lead->description;
                $data['tags'] = $lead->tags;
                $data['lastContacted'] = $lead->lastContacted;
                $data['followUpDate'] = $lead->followUpDate;
                $data['officePhone'] = $lead->officePhone;
                $data['phoneExt'] = $lead->phoneExt;
                $data['mobilePhone'] = $lead->mobilePhone;
                $data['email'] = $lead->email;
                $data['street'] = $lead->street;
                $data['city'] = $lead->city;
                $data['country'] = $lead->country;
                $data['state'] = $lead->state;
                $data['zip'] = $lead->zip;
                $data['facebook'] = $lead->facebook;
                $data['twitter'] = $lead->twitter;
                $data['linkedIn'] = $lead->linkedIn;
                $data['website'] = $lead->website;
                $data['modifiedBy'] = $lead->modifiedBy;
                $data['modifiedOn'] = $lead->modifiedOn;
                $data['createdBy'] = $lead->createdBy;
                $data['createdOn'] = $lead->createdOn;


            fputcsv($output, $data);
        }

        fclose($output);


    }catch(Exception $e) {
        die($e->getMessage());
    }


}