<?php
use thipages\quick\QTag2;
class Tests_VoidTags {
    public static function dataSet() {
        $blue=['style'=>'color:blue'];
        $type=['type'=>'number'];
        $min=['min'=>0];
        return [
            [
                QTag2::tag('input'),
                '<input />',
                'tag() without attributesMap'
            ],[
                QTag2::tag('input',$type),
                '<input type="number" />',
                'tag() with attributesMap'
            ],[
                QTag2::tag('input',$type,true)($blue),
                '<input type="number" style="color:blue" />',
                'tag() with chained attributesMap'
            ],[
                QTag2::tag('input',$type,true)($blue,true)($min),
                '<input type="number" style="color:blue" min="0" />',
                'tag() with 1chained attributesMap'
            ]
        ];
    }
}





