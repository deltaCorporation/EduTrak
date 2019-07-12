<?php

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/core/ini.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$lead = new Lead();
$user = new User();

if($user->isLoggedIn()) {

    $fileName = 'leads.xlsx';
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
                    'prefix' => $data[$i][0],
                    'firstName' => $data[$i][1],
                    'lastName' => $data[$i][2],
                    'jobTitle' => $data[$i][4],
                    'category' => 'Private School',
                    'company' => $data[$i][5],
                    'email' => $data[$i][6],
                    'city' => $data[$i][7],
                    'state' => $data[$i][8],
                    'archDiocese' => $data[$i][9],
                    'reachedUsBy' => 'Event',
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