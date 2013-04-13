/*
    Generated File
*/

<?php
require_once("inc/globals.php");
global $app;

header("content-type: text/plain; charset=utf-8");

// tables

$sql_section = array("wfw_base","dod_module_base");
foreach($sql_section as $key=>$section){
    $path = $app->getCfgValue("sql_tables",$section);
    if(empty($path))
        continue;
    $sql_file = realpath($path);

    if(file_exists($sql_file)){
        echo("/* ********************************************************************************************* */\n");
        echo("/* INCLUDE FROM $sql_file */\n");
        echo("/* ********************************************************************************************* */\n");
        echo(file_get_contents($sql_file)."\n\n");
    }
    else{
        echo("/* ********************************************************************************************* */\n");
        echo("/* NOT FOUND $path */\n");
        echo("/* ********************************************************************************************* */\n");
    }
}

//OK pour toutes les fonctions et init.
$sql_section = array("sql_func","sql_init");
foreach($sql_section as $key=>$section){
    $path_section = $app->getCfgSection($section);
    if(isset($path_section)){
        foreach($path_section as $name=>$path){
            $sql_file = realpath($path);
            if(empty($sql_file))
                continue;

            if(file_exists($sql_file)){
                echo("/* ********************************************************************************************* */\n");
                echo("/* INCLUDE FROM $sql_file */\n");
                echo("/* ********************************************************************************************* */\n");
                echo(file_get_contents($sql_file)."\n\n");
            }
            else{
                echo("/* ********************************************************************************************* */\n");
                echo("/* NOT FOUND $path */\n");
                echo("/* ********************************************************************************************* */\n");
            }
        }
    }
}


// jeux d'essais

$sql_section = array("dod_module_base");
foreach($sql_section as $key=>$section){
    $path = $app->getCfgValue("sql_populate",$section);
    if(empty($path))
        continue;
    $sql_file = realpath($path);

    if(file_exists($sql_file)){
        echo("/* ********************************************************************************************* */\n");
        echo("/* INCLUDE FROM $sql_file */\n");
        echo("/* ********************************************************************************************* */\n");
        echo(file_get_contents($sql_file)."\n\n");
    }
    else{
        echo("/* ********************************************************************************************* */\n");
        echo("/* NOT FOUND $path */\n");
        echo("/* ********************************************************************************************* */\n");
    }
}

?>