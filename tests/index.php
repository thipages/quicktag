<?php
include('../vendor/autoload.php');
include_once('Tests_QTag.php');
include_once('Tests_QT.php');
include_once('Tests.php');

use thipages\quick\QTag;
$output=Tests::getOutput(
    [Tests_QTag::class, Tests_QT::class]
);
$page=QTag::html(
    [
        QTag::head('',"quicktag Tests"),
        QTag::body($output)
    ]
);
echo($page);