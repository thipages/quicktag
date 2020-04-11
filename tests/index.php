<?php
include('../vendor/autoload.php');
include_once('Tests_QTag.php');
include_once('Tests_QT.php');
include_once('Tests.php');

$output=Tests::getOutput(
    [Tests_QTag::class, Tests_QT::class]
);
echo($output);