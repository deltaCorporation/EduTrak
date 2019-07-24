<?php

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/core/ini.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$inventory = new Inventory();
$user = new User();

if($user->isLoggedIn()) {

    $fileName = 'digital.csv';
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
                    'eduscapeSKU' => escape($data[$i][0]),
                    'workshopGroups' => escape($data[$i][1]),
//                    'track' => escape($data[$i][2]),
                    'format' => escape($data[$i][3]),
                    'time' => escape($data[$i][4]),
                    'titleOfOffering' => escape($data[$i][5]),
                    'description' => escape($data[$i][6]),
                    'learnerOutcomes' => escape($data[$i][7]),
                    'prerequisites' => escape($data[$i][8]),
                    'toolbox' => escape($data[$i][9]),
                    'status' => escape($data[$i][10]),
                ]);

            }
        }

    }catch (Exception $e) {
        die($e->getMessage());
    }
}