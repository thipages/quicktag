<?php

namespace thipages\quick;

class QT {
    const VOID_TAGS=[
        'area', 'base', 'br', 'col', 'command', 'embed', 'hr','img', 'input',
        'keygen', 'link', 'meta', 'param', 'source', 'track', 'wbr'
    ];
    public static function wrapper($wrapper) {
        return function  ($content,$toHtml) use($wrapper){
            $wrapper['_content']=$content;
            return $toHtml?self::toHtml($wrapper):$wrapper;
        };
    }
    public static function merger($content1) {
        return function  ($content2,$toHtml) use($content1){
            $m= array_merge($content1,$content2);
            return $toHtml?self::toHtml($m):$m;
        };
    }
    /*public static function deepMerger($contentMap) {
        return null;
    }*/
    private static function setPropAndRemove(&$a,$prop,$default) {
        if (isset($a[$prop])) {
            $res=$a[$prop];
            unset($a[$prop]);
        } else {
            $res=$default;
        }
        return $res;
    }
    private static function _getHtml($content) {
        $tag=self::setPropAndRemove($content,'_tag','div');
        if (isset($content['_content'])) {
            $c=$content['_content'];
            unset($content['_content']);
            $c=is_string($c)?$c:self::toHtml($c);
        } else {
            $c='';
        }
        $attributeMap=self::getAttributeMapToString($content);
        return self::tag($tag,$c,$attributeMap);
    }
    public static function toHtml($contents=null) {
        $html=[];
        if ($contents==null) $html[]=self::_getHtml(['_tag'=>'div']);
        else if (Tools::isAssociativeArray($contents)) {
            $html[]=self::_getHtml($contents);
        } else {
            foreach ($contents as $content) $html[]=self::_getHtml($content);
        }
        return join('',$html);
    }
    public static function isVoidTag($tag) {
        return in_array($tag,self::VOID_TAGS);
    }
    public static function getAttributeMapToString($attributeMap=[]) {
        Tools::defaultToArray($attributeMap);
        if (is_array($attributeMap)) {
            $attributes = [];
            $attributes_bool = [];
            foreach ($attributeMap as $k => $v) {
                if ($k==='style' && is_array($v)) $v=join(';',$v);
                if ($k==='class' && is_array($v)) $v=join(' ',$v);
                if (is_bool($v)) {
                    if ($v) $attributes_bool[]=$k;
                } else {
                    $attributes[] = "$k=\"$v\"";
                }
            }
            return join (" ", array_merge($attributes, $attributes_bool));
        } else {
            return $attributeMap;
        }
    }
    public static function tag($tag, $content, $attributeMap) {
        if (self::isVoidTag($tag)) return self::voidTag($tag,$attributeMap);
        Tools::defaultToArray($content,true);
        $sAttr=self::getAttributeMapToString($attributeMap);
        $res=[];
        foreach ($content as $c) $res[]= $c;
        $sAttr=$sAttr?" $sAttr":'';
        return "<$tag$sAttr>".join('',$res)."</".$tag.">";
    }
    public static function voidTag($tag,$attributeMap) {
        $sAttr=self::getAttributeMapToString($attributeMap);
        $sAttr= $sAttr?" $sAttr":'';
        return "<$tag$sAttr />";
    }
}