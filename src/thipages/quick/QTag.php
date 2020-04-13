<?php

namespace thipages\quick;
class QTag {
    public static function tag($tag='div', $content='', ...$attributeMaps) {
        $c=is_array($content)?join('',$content):$content;
        return self::toHtml($tag,$c,self::_mergeAttributes(...$attributeMaps));
    }
    public static function voidTag($tag,...$attributeMaps) {
        return self::tag($tag,'',...$attributeMaps);
    }
    public static function tagN($tag='div',$contents=[],...$attributeMaps) {
        $html=[];
        foreach($contents as $c) {
            $html[]=self::toHtml($tag,$c,self::_mergeAttributes(...$attributeMaps));
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
        return QT::toHtml(array_merge($attributeMap,[
            '_tag'=>$tag,
            '_content'=>$content,
        ]));
    }
    private static function _mergeAttributes(...$attributeMaps) {
        foreach ($attributeMaps as &$attributeMap)Tools::defaultToArray($attributeMap);
        return self::mergeAttributes(...$attributeMaps);
    }
    public static function mergeAttributes(...$attributeMaps) {
        $css=['style','class'];
        $delimiter=[';',' '];
        $special=[];
        foreach ($css as $key) $special[$key]=[];
        foreach ($css as $key) {
            foreach ($attributeMaps as $attr) {
                if (isset($attr[$key])) {
                    $special[$key][]=$attr[$key];
                    unset($attr[$key]);
                }
            }
        }
        $merge=array_merge(...$attributeMaps);
        for ($i=0;$i<2;$i++) {
            $k=$css[$i];
            if ($special[$k]!=null) $merge[$k]=join($delimiter[$i],$special[$k]);
        }
        return $merge;
    }
}