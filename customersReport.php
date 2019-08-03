<?php

/*
 * Require ini file with settings
 */
require_once __DIR__ . '/core/ini.php';

$user = new User();
$customer = new Customer();

if($user->isLoggedIn()){

    try{

        $fileName = 'customer-report';

        // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$fileName.'.csv');

        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        $csvHeader = array(
            'ID',
            'Name',
            'Category',
            'Partner Rep',
            'Reached Us By',
            'Description',
            'Tags' ,
            'Last Contacted',
            'Partner',
            'Parent Customer',
            'Office Phone',
            'Phone Ext',
            'Mobile Phone',
            'Email',
            'Fax',
            'Accounts Payable Info',
            'Street',
            'City',
            'State',
            'Country',
            'Zip',
            'FollowUp Date',
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

        foreach ($customer->getCustomers() as $customer){

            $data = array();


            $data['id'] = $customer->id;
            $data['name'] = $customer->name;
            $data['category'] = $customer->category;
            $data['partnerRep'] = $customer->partnerRep;
            $data['reachedUsBy'] = $customer->reachedUsBy;
            $data['description'] = $customer->description;
            $data['tags'] = $customer->tags;
            $data['lastContacted'] = $customer->lastContacted;
            $data['partner'] = $customer->partner;
            $data['parentCustomer'] = $customer->parentCustomer;
            $data['officePhone'] = $customer->officePhone;
            $data['phoneExt'] = $customer->phoneExt;
            $data['mobilePhone'] = $customer->mobilePhone;
            $data['email'] = $customer->email;
            $data['fax'] = $customer->fax;
            $data['accountsPayableInfo'] = $customer->accountsPayableInfo;
            $data['street'] = $customer->street;
            $data['city'] = $customer->city;
            $data['state'] = $customer->state;
            $data['country'] = $customer->country;
            $data['zip'] = $customer->zip;
            $data['followUpDate'] = $customer->followUpDate;
            $data['facebook'] = $customer->facebook;
            $data['twitter'] = $customer->twitter;
            $data['linkedIn'] = $customer->linkedIn;
            $data['website'] = $customer->website;
            $data['createdBy'] = $customer->createdBy;
            $data['createdOn'] = $customer->createdOn;
            $data['modifiedBy'] = $customer->modifiedBy;
            $data['modifiedOn'] = $customer->modifiedOn;


                fputcsv($output, $data);
        }

        fclose($output);


    }catch(Exception $e) {
        die($e->getMessage());
    }


}