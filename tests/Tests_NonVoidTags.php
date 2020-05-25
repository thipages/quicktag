<?php
use thipages\quick\QTag;
class Tests_NonVoidTags {
    public static function dataSet() {
        $blue=['style'=>'color:blue'];
        $classA=['class'=>'A'];
        return [
           [
                QTag::tag('div')('Hello QTag'),
                '<div>Hello QTag</div>',
                'tag() without attributesMap, string content'
            ],
            [
                QTag::tag('div')(1),
                '<div>1</div>',
                'tag() without attributes, number content'
            ],
            [
                QTag::tag('div')([
                    QTag::tag('textarea')(''),
                    QTag::tag('div')('')
                ]),
                '<div><textarea></textarea><div></div></div>',
                'tag() with array content'
            ],
            [
                QTag::tag('div')([
                    1,2
                ]),
                '<div>12</div>',
                'tag() with array content (numbers)'
            ],
            [
                QTag::tag('div', $blue)('Hello QTag'),
                '<div style="color:blue">Hello QTag</div>',
                'tag() with one attributesMap'
            ],
            [
                QTag::tag('div', $blue, $classA)('Hello QTag'),
                '<div style="color:blue" class="A">Hello QTag</div>',
                'tag() with multiple attributesMap'
            ],
            [
                QTag::tag('div', $blue)('Hello QTag',$classA),
                '<div style="color:blue" class="A">Hello QTag</div>',
                'tag() with a last attributesMap'
            ],
            [
                QTag::tag('div', $blue)($classA)('Hello QTag'),
                '<div style="color:blue" class="A">Hello QTag</div>',
                'tag() with chained attributesMap'
            ],
            [
                QTag::tag('div')($blue,$classA)('Hello QTag'),
                '<div style="color:blue" class="A">Hello QTag</div>',
                'tag() with multiple chained attributesMap'
            ],
            [
                QTag::div('Hello QTag'),
                '<div>Hello QTag</div>',
                'tag() without attributesMap, string content'
            ],[
                QTag::tag('div')($blue,$classA)('Hello QTag', true)('...more'),
                '<div style="color:blue" class="A">Hello QTag...more</div>',
                'tag() with multiple chained attributesMap'
            ],
            [
                QTag::html('',''),
                '<!DOCTYPE html>'."\n".'<html lang="en"></html>',
                'html() '
            ]
            
        ];
    }
}





