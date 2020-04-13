<?php

namespace thipages\quick;
class QTag {
    public static function tag($tag='div', $content='', $attributeMap1=[],$attributeMap2=[]) {
        $c=is_array($content)?join('',$content):$content;
        return self::toHtml($tag,$c,self::_mergeAttributes($attributeMap1,$attributeMap2));
    }
    public static function voidTag($tag,$attributeMap1=[],$attributeMap2=[]) {
        return self::tag($tag,'',$attributeMap1,$attributeMap2);
    }
    public static function tagN($tag='div',$contents=[],$attributeMap1=[],$attributeMap2=[]) {
        $html=[];
        foreach($contents as $c) {
            $html[]=self::toHtml($tag,$c,self::_mergeAttributes($attributeMap1,$attributeMap2));
        }
        return join('',$html);
    }
    public static function div($content='', $attributeMap1=[],$attributeMap2=[]) {
        return self::tag('div',$content,$attributeMap1,$attributeMap2);
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
    private static function _mergeAttributes($attributeMap1, $attributeMap2) {
        Tools::defaultToArray($attributeMap1);
        Tools::defaultToArray($attributeMap2);
        return self::mergeAttributes($attributeMap1,$attributeMap2);
    }
    public static function mergeAttributes($attr1,$attr2) {
        if ($attr1==null || $attr2==null) return array_merge($attr1,$attr2);
        $css=['style','class'];
        $delimiter=[';',' '];
        $special=[];
        foreach ($css as $key) $special[$key]=[];
        foreach ($css as $key) {
            foreach ([$attr1, $attr2] as $attr) {
                if (isset($attr[$key])) {
                    $special[$key][]=$attr[$key];
                    unset($attr[$key]);
                }
            }
        }
        $merge=array_merge($attr1,$attr2);
        for ($i=0;$i<2;$i++) {
            $k=$css[$i];
            if ($special[$k]!=null) $merge[$k]=join($delimiter[$i],$special[$k]);
        }
        return $merge;
    }
}