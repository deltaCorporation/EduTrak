<?php

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/core/ini.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$lead = new Lead();
$user = new User();

if($user->isLoggedIn()) {


    $fileName = 'ISTE 2019.xls';
    $filePath = __DIR__ . '/temp/' . $fileName;
    $fileExt = ucfirst(explode('.', $fileName)[1]);

    if (!file_exists($filePath)) {
        echo PHP_EOL . "Source file {$fileName} doesn't exist!!!" . PHP_EOL;
        exit;
    }

    try {

        $spreadsheet = new Spreadsheet();

        /**  Create a new Reader of the type defined in $inputFileType  **/
        /** @var Xlsx $reader */
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($fileExt);
        /**  Advise the Reader that we only want to load cell data  **/

        $reader->setReadDataOnly(true);
        $file = $reader->load($filePath);
        $sheet = $file->getActiveSheet();

        $data = $sheet->toArray();

        for ($i = 1; $i < count($data); $i++) {
            if($data[$i][1] !== '' || $data[$i][1] !== null){
                $id = date('ymdhis') + $i;

                $lead->create([
                    'id' => $id,
                    'firstName' => $data[$i][0],
                    'lastName' => $data[$i][1],
                    'company' => $data[$i][3],
                    'street' => $data[$i][4],
                    'city' => $data[$i][5],
                    'state' => $data[$i][6],
                    'zip' => $data[$i][7],
                    'country' => $data[$i][8],
                    'email' => $data[$i][9],
                    'officePhone' => $data[$i][10],
                    'jobTitle' => $data[$i][11],
                    'reachedUsBy' => 'Event',
                    'assignedTo' => 190627035028,
                    'eventName' => explode('.', $fileName)[0],
                    'createdBy' => $user->data()->firstName.' '.$user->data()->lastName,
                    'createdOn' => date('n/j/y'),
                    'lastContacted' => 'Not contacted',
                    'modifiedBy' => '-',
                    'modifiedOn' => '-',
                ]);
            }
        }

        echo 'done';


    } catch (Exception $e) {
        die($e->getMessage());
    }
}else{
    echo 'You are not logged in!';
}