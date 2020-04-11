<?php

include_once('./../src/thipages/quick/QTag.php');
include_once('../src/thipages/quick/QT.php');
include_once('../src/thipages/quick/Tools.php');
include_once('GenericTable.php');
include_once('Tests_QTag.php');
include_once('Tests_QT.php');
include_once('Tests.php');

$output=Tests::getOutput(
    [Tests_QTag::class, Tests_QT::class]
);
echo($output);