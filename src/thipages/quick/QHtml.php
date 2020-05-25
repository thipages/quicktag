<?php
namespace thipages\quick;
class QHtml {
    public static function nonVoidTag($tag, $content, $attributeMap) {
        self::defaultToArray($content,true);
        $sAttr=self::getAttributeMapToString($attributeMap);
        //$res=[];
        //foreach ($content as $c) $res[]= $c;
        $sAttr=$sAttr?" $sAttr":'';
        return "<$tag$sAttr>".join('',$content)."</".$tag.">";
    }
    public static function voidTag($tag, $attributeMap=null) {
        $sAttr=$attributeMap?' '.self::getAttributeMapToString($attributeMap):'';
        return "<$tag$sAttr />";
    }
    private static function joinKeyedArray($a,$del1, $del2) {
        return join($del2,array_walk($a,function ($v,$k) use($del1) {
           return "$k$del1$v"; 
        }));
    }
    private static function defaultToArray(&$a,$forceArray=false) {
        if ($a==null) {
            $a=[];
        } else if ($forceArray && !is_array($a)) {
            $a=[$a];
        }
    }
    private static function getAttributeMapToString($attributeMap=[]) {
        self::defaultToArray($attributeMap);
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
}