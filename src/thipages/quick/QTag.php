<?php

namespace thipages\quick;
class QTag {
    public static function tag($tag='div', $content='', $attributeMap=[]) {
        Tools::defaultToArray($attributeMap);
        $c=is_array($content)?join('',$content):$content;
        return self::toHtml($tag,$c,$attributeMap);
    }
    public static function voidTag($tag,$attributeMap=[]) {
        return self::tag($tag,'',$attributeMap);
    }
    public static function tagN($tag='div',$contents=[],$attributeMap=[]) {
        $html=[];
        foreach($contents as $c) {
            $html[]=self::toHtml($tag,$c,$attributeMap);
        }
        return join('',$html);
    }
    public static function div($content='', $attributeMap=[]) {
        return self::tag('div',$content,$attributeMap);
    }
    public static function html($content, $attributes=['lang'=>'en']) {
        return join('\n',
            ['<!DOCTYPE html>',self::tag('html',$content,$attributes)]
        );
    }
    public static function head($content,$title,$charset='utf-8') {
        return self::tag('head',
            [
                "<meta charset=\"$charset\">",
                "<title>$title</title>",
                $content
            ]
        );
    }
    public static function body($content) {
        return self::tag('body',$content);    
    }
    private static function toHtml ($tag,$content,$attributeMap) {
        return QT::toHtml(array_merge($attributeMap,[
            '_tag'=>$tag,
            '_content'=>$content,
        ]));
    }
}