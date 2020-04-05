<?php
use thipages\quick\QT;
class Tests_QT {
    public static function tests() {
        $merger=QT::merger([]);
        $wrapper1=QT::wrapper(['c'=>1]);
        $wrapper2=QT::wrapper(['c'=>1,'_content'=>['c'=>2,'_content'=>[]]]);
        return [
            [
                QT::toHtml(),
                '<div></div>',
                'toHtml() without argument'
            ],[
                QT::toHtml([]),
                '<div></div>',
                'toHtml() with an empty array'
            ],[
                QT::toHtml(['_tag'=>'div', '_content'=>'a', 'id'=>'id1']),
                '<div id="id1">a</div>',
                'toHtml() with differents keys'
            ], [
                QT::toHtml(['id'=>'id1']),
                '<div id="id1"></div>',
                'toHtml() with no _tag and _content keys'
            ],[
                QT::toHtml(['style'=>['color:blue','margin:0']]),
                '<div style="color:blue;margin:0"></div>',
                'toHtml() with style array'
            ],[
                QT::toHtml(['class'=>['c1','c2']]),
                '<div class="c1 c2"></div>',
                'toHtml() with class array'
            ],[
                QT::toHtml(
                    [
                        ['_content'=>'a'],
                        ['_content'=>'b']
                    ]
                ),
                '<div>a</div><div>b</div>',
                'toHtml() with array of array'
            ],[
                QT::toHtml(['_content'=>[
                    ['_content'=>'a'],
                    ['_content'=>'b']
                ]]),
                '<div><div>a</div><div>b</div></div>',
                'toHtml() with nested array content'
            ],[
                QT::toHtml(['_content'=>['_content'=>'a']]),
                '<div><div>a</div></div>',
                'toHtml - nested content'
            ],[
                $merger(['class'=>'c'],true),
                '<div class="c"></div>',
                'merger()'
            ],[
                $wrapper1(['c'=>2],true),
                '<div c="1"><div c="2"></div></div>',
                'wrapper()'
            ],[
                $wrapper2(['c'=>3],true),
                '<div c="1"><div c="2"><div c="3"></div></div></div>',
                'wrapper() nested'
            ]
        ];
    }
}





