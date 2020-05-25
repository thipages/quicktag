<?php
include('../vendor/autoload.php');
include_once('Tests_NonVoidTags.php');
include_once('Tests_VoidTags.php');

use thipages\quick\tests\QTests;
use thipages\quick\QTag;
$output=QTests::test(
    [Tests_NonVoidTags::class,Tests_VoidTags::class],true
);
/*$page=QTag::html(
    [
        //QTag::div(['id'=>"id1"])(QTag::div(['onclick'=>'handleEvents(event);'])("test js")),
        //QTag::head(QTag::tag('script','',['src'=>'index.js']),"quicktag Tests"),
        QTag::body()($output)
    ]
);*/
echo($output);

