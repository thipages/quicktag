<?php
class QTag {
    public static function tag($tag='div', $content='', ...$attributeMaps) {
        $c=is_array($content)?join('',$content):$content;
        return self::toHtml($tag,$c,QTagUtils::mergeAttributes(...$attributeMaps));
    }
    public static function emptyTag($tag,...$attributeMaps) {
        return self::tag($tag,'',...$attributeMaps);
    }
    public static function tagN($tag='div',$contents=[],...$attributeMaps) {
        $html=[];
        foreach($contents as $c) {
            $html[]=self::toHtml($tag,$c,QTagUtils::mergeAttributes(...$attributeMaps));
        }
        return $html;
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
    public static function prep($tag, ...$attributesMap) {
        return function ($content) use($tag,$attributesMap) {
            return QTagUtils::isAssociativeArray($content) 
                ? self::prep($tag,QTagUtils::mergeAttributes(...$attributesMap,...[$content]))
                : self::tag($tag,$content,...$attributesMap);
        };
    }
    public static function prepN(...$prepareList) {
        return function (...$contentList) use($prepareList) {
            return QTagUtils::isAssociativeArray($contentList[0])
                ? self::prepN(
                    ...array_map(
                        function($v,$k) use ($prepareList,$contentList) {
                            return $v($contentList[$k]);
                        }, $prepareList, array_keys($prepareList)
                    ))
                : array_map(
                    function($v,$k) use ($contentList){
                        return $v($contentList[$k]);
                    }, $prepareList, array_keys($prepareList)
                );
        };
    }
}
class QTagUtils {
    const VOID_TAGS=[
        'area', 'base', 'br', 'col', 'command', 'embed', 'hr','img', 'input',
        'keygen', 'link', 'meta', 'param', 'source', 'track', 'wbr'
    ];
    public static function defaultToArray(&$a,$forceArray=false) {
        if ($a==null) {
            $a=[];
        } else if ($forceArray && !is_array($a)) {
            $a=[$a];
        }
    }
    public static function isAssociativeArray($a) {
        if ($a==null || !is_array($a)) return false;
        return array_keys($a) !== range(0, count($a) - 1);
    }
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
            $c=is_scalar($c)?$c:self::toHtml($c);
        } else {
            $c='';
        }
        $attributeMap=self::getAttributeMapToString($content);
        return self::tag($tag,$c,$attributeMap);
    }
    public static function toHtml($contents=null) {
        $html=[];
        if ($contents==null) {
            $html[]=self::_getHtml(['_tag'=>'div']);
        } else if (self::isAssociativeArray($contents)) {
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
    public static function tag($tag, $content, $attributeMap) {
        if (self::isVoidTag($tag)) return self::voidTag($tag,$attributeMap);
        self::defaultToArray($content,true);
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