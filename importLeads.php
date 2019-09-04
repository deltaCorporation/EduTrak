<?php

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/core/ini.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$lead = new Lead();
$user = new User();

if($user->isLoggedIn()) {


    $fileName = 'upload.xls';
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
                    'company' => $data[$i][3],
                    'email' => $data[$i][4],
                    'officePhone' => $data[$i][5],
                    'phoneExt' => $data[$i][6],
                    'jobTitle' => $data[$i][7],
                    'assignedTo' => 190627035028,
                    'createdBy' => 'Katrina Keene',
                    'createdOn' => $data[$i][8],
                    'lastContacted' => $data[$i][10] ? $data[$i][10] : 'Not contacted',
                    'modifiedBy' => $data[$i][9] ? 'Katrina Keene' : '-',
                    'modifiedOn' => $data[$i][9],
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