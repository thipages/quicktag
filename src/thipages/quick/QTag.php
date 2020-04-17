<?php

namespace thipages\quick;
class QTag {
    public static function tag($tag='div', $content='', ...$attributeMaps) {
        $c=is_array($content)?join('',$content):$content;
        return self::toHtml($tag,$c,QTagUtils::mergeAttributes(...$attributeMaps));
    }
    public static function voidTag($tag,...$attributeMaps) {
        return self::tag($tag,'',...$attributeMaps);
    }
    public static function tagN($tag='div',$contents=[],...$attributeMaps) {
        $html=[];
        foreach($contents as $c) {
            $html[]=self::toHtml($tag,$c,QTagUtils::mergeAttributes(...$attributeMaps));
        }
        return join('',$html);
    }
    public static function div($content='', ...$attributeMaps) {
        return self::tag('div',$content,...$attributeMaps);
    }
    public static function html($content, $attributes=['lang'=>'en']) {
        return join("\n",
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
    public static function body($content, $attributeMap=[]) {
        return self::tag('body',$content,$attributeMap);    
    }
    private static function toHtml ($tag,$content,$attributeMap) {
        return QTagUtils::toHtml(array_merge($attributeMap,[
            '_tag'=>$tag,
            '_content'=>$content,
        ]));
    }
    
    public static function wrap($tag,...$attributesMap) {
        return function ($content) use($tag,$attributesMap) {
            return self::tag($tag,$content,...$attributesMap);
        };
    }
    public static function preWrap($tag,...$attributeMap) {
        return function (...$attributeMap2) use ($tag,$attributeMap){
            $attributes=QTagUtils::mergeAttributes(...$attributeMap, ...$attributeMap2);
            return self::wrap($tag, $attributes);
        };
    }
}