<?php
use thipages\quick\QTag;
class Tests_VoidTags {
    public static function dataSet() {
        $blue=['style'=>'color:blue'];
        $type=['type'=>'number'];
        $min=['min'=>0];
        return [
            [
                QTag::tag('input'),
                '<input />',
                'tag() without attributesMap'
            ],[
                QTag::tag('input',$type),
                '<input type="number" />',
                'tag() with 1 attributesMap'
            ],[
                QTag::tag('input',$type, $blue),
                '<input type="number" style="color:blue" />',
                'tag() with 2 attributesMap'
            ],[
                QTag::tag('input', $type,true)($blue),
                '<input type="number" style="color:blue" />',
                'tag() with chained 1 attributesMap'
            ],[
                QTag::tag('input', $type,true)(),
                '<input type="number" />',
                'tag() with empty chained 1 attributesMap'
            ],[
                QTag::tag('input',$min,$type,true)($blue),
                '<input min="0" type="number" style="color:blue" />',
                'tag() with chained 2 attributesMap'
            ],[
                QTag::tag('input',$type,true)($blue,true)($min),
                '<input type="number" style="color:blue" min="0" />',
                'tag() with double chained attributesMap'
            ]
        ];
    }
}




