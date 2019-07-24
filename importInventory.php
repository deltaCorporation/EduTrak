<?php

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/core/ini.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$inventory = new Inventory();
$user = new User();

if($user->isLoggedIn()) {

    $fileName = 'stem.csv';
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
            if ($data[$i][1] !== '' || $data[$i][1] !== null) {
                $id = date('ymdhis') + $i;

                $inventory->create([
                    'id' => $id,
                    'eduscapeSKU' => $data[$i][0],
                    'workshopGroups' => $data[$i][1],
//                    'track' => $data[$i][2],
                    'format' => $data[$i][2],
                    'time' => $data[$i][3],
                    'titleOfOffering' => $data[$i][4],
                    'description' => $data[$i][5],
                    'learnerOutcomes' => $data[$i][6],
                    'prerequisites' => $data[$i][7],
                    'toolbox' => $data[$i][8],
                    'status' => $data[$i][9],
                ]);

            }
        }

    }catch (Exception $e) {
        die($e->getMessage());
    }
}