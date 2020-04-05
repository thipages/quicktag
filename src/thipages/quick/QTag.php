<?php

namespace thipages\quick;
class QTag {
    public static function tag($tag='div', $content='', $attributeMap=[]) {
        Tools::defaultToArray($attributeMap);
        $c=is_array($content)?join('',$content):$content;
        return QT::toHtml(array_merge($attributeMap,[
            '_tag'=>$tag,
            '_content'=>$c,
        ]));
    }
    public static function voidTag($tag,$attributeMap=[]) {
        return self::tag($tag,'',$attributeMap);
    }
    public static function div($content='', $attributeMap=[]) {
        return self::tag('div',$content,$attributeMap);
    }

}