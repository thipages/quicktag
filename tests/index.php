<?php
include('../vendor/autoload.php');
include_once('Tests_NonVoidTags.php');
include_once('Tests_VoidTags.php');

use thipages\quick\tests\QTests;
/*$output=QTests::test(
    [Tests_NonVoidTags::class,Tests_VoidTags::class],true
);
$page=QTag::html(
    [
        QTag::div(QTag::div("test js",['onclick'=>'handleEvents(event);']),['id'=>"id1"]),
        QTag::head(QTag::tag('script','',['src'=>'index.js']),"quicktag Tests"),
        QTag::body($output)
    ]
);
echo($page);*/

