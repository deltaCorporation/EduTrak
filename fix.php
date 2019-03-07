<?php

    require_once __DIR__ . '/core/ini.php';

    $inventory = new Inventory();

    try{
        $inventory->update(array(
            'materials' => 'o'
        ), 'EDU_GA000');

        echo 'fix';
    }catch (Exception $e){
        die($e->getMessage());
    }

    /*
     *
     *
     *
     *
     *
     */