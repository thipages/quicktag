<?php
use thipages\quick\QTag;
class Tests_QTag {
    public static function dataSet() {
        return [
            [
                QTag::tag(),
                '<div></div>',
                'tag() without argument'
            ],
            [
                QTag::tag('div'),
                '<div></div>',
                'tag() with first argument only'
            ], [
                QTag::tag('div', 'a'),
                '<div>a</div>',
                'tag() with string content argument'
            ], [
                QTag::tag('div', [QTag::tag(), QTag::tag()]),
                '<div><div></div><div></div></div>',
                'tag() with array content argument'
            ], [
                QTag::tag('div', 'a', ['style' => 'color:red']),
                '<div style="color:red">a</div>',
                'tag() with attribute argument'
            ], [
                QTag::tag('div', 'a', ['style' => 'color:red'],['style' => 'padding:5px']),
                '<div style="color:red;padding:5px">a</div>',
                'tag() with two style attribute arguments'
            ], [
                QTag::tag('div', 'a', ['class' => 'a'],['class' => 'b']),
                '<div class="a b">a</div>',
                'tag() with two class attribute arguments'
            ], [
                QTag::tag('div', 'a', ['class' => 'a'],['class' => 'b','data-id'=>1]),
                '<div class="a b" data-id="1">a</div>',
                'tag() with two mix attribute arguments'
            ],
            [
                QTag::div(),
                '<div></div>',
                'div() without argument'
            ],
            [
                QTag::tagN('div',[1,2]),
                '<div>1</div><div>2</div>',
                'tagN()'
            ],
            [
                QTag::html(
                    [QTag::head('',"a title"),QTag::body('Hello QTag')]
                ),
                '<!DOCTYPE html>'."\n".'<html lang="en"><head><meta charset="utf-8"><title>a title</title></head><body>Hello QTag</body></html>',
                'html(), head() and body()'               
            ]
        ];
    }
}





