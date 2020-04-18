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
            ],
            [
                QTag::emptyTag('input'),
                '<input />',
                'empty()'
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
            ],
            [
                QTag::prep('div',['id'=>'id1'])(QTag::div('wrapped',['id'=>'id2'])),
                '<div id="id1"><div id="id2">wrapped</div></div>',
                'prepare() with content second argument'
            ],
            [
                 QTag::prep('div',['id'=>'id1'])(['style'=>'color:blue'])(QTag::div('wrapped',['id'=>'id2'])),
                 '<div id="id1" style="color:blue"><div id="id2">wrapped</div></div>',
                 'prepare() with attribute as second argument'
            ],
            [
                QTag::prepN(
                    QTag::prep('label'),QTag::prep('div')
                )('labelText','divText'),
                '<label>labelText</label><div>divText</div>',
                'prepareN() with content as second argument'
            ],
            [
                QTag::prepN(
                    QTag::prep('input'),QTag::prep('div')
                )('','divText'),
                '<input /><div>divText</div>',
                'prepareN() with empty content/tag as second argument'
            ],
            [
                QTag::prepN(
                    QTag::prep('label'),QTag::prep('div')
                )(['a'=>1],['b'=>2])('labelText','divText'),
                '<label a="1">labelText</label><div b="2">divText</div>',
                'prepareN() with attributes as second argument'
            ]
        ];
    }
}





