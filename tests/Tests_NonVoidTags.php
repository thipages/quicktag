<?php
use thipages\quick\QTag2;
class Tests_NonVoidTags {
    public static function dataSet() {
        $blue=['style'=>'color:blue'];
        $classA=['class'=>'A'];
        return [
           [
                QTag2::tag('div')('Hello QTag'),
                '<div>Hello QTag</div>',
                'tag() without attributesMap, string content'
            ],
            [
                QTag2::tag('div')(1),
                '<div>1</div>',
                'tag() without attributes, number content'
            ],
            [
                QTag2::tag('div', $blue)('Hello QTag'),
                '<div style="color:blue">Hello QTag</div>',
                'tag() with 1 direct attributesMap'
            ],
            [
                QTag2::tag('div', $blue, $classA)('Hello QTag'),
                '<div style="color:blue" class="A">Hello QTag</div>',
                'tag() with 2 direct attributesMap'
            ],
            [
                QTag2::tag('div', $blue)($classA)('Hello QTag'),
                '<div style="color:blue" class="A">Hello QTag</div>',
                'tag() with chained attributesMap'
            ],
            [
                QTag2::tag('div', $blue)('Hello QTag',$classA),
                '<div style="color:blue" class="A">Hello QTag</div>',
                'tag() with a last attributesMap'
            ],
            [
                QTag2::tag('div', $blue)('Hello QTag',$classA),
                '<div style="color:blue" class="A">Hello QTag</div>',
                'tag() with a last attributesMap'
            ],
            [
                QTag2::tag('div')($blue,$classA)('Hello QTag'),
                '<div style="color:blue" class="A">Hello QTag</div>',
                'tag() with chained multiple attributesMap'
            ], [
            QTag2::tag('div')([
                QTag2::tag('input'),
                QTag2::tag('div')('')
            ]),
                '<div><input /><div></div></div>',
                'tag() with array content'
            ]
        ];
    }
}





