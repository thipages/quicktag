<?php
include('../vendor/autoload.php');
include_once('Tests_QTag.php');
include_once('Tests_QT.php');

use thipages\quick\QTag;
use thipages\quick\tests\QTests;
$output=QTests::getOutput(
    [Tests_QTag::class, Tests_QT::class]
);
$page=QTag::html(
    [
        QTag::div(QTag::div("test js",['onclick'=>'handleEvents(event);']),['id'=>"id1"]),
        QTag::head(QTag::tag('script','',['src'=>'index.js']),"quicktag Tests"),
        QTag::body($output)
    ]
);
echo($page);

