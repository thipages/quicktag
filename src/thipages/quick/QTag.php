<?php
namespace thipages\quick;
class QTag {
    const VOID_TAGS=[
        'area', 'base', 'br', 'col', 'command', 'embed', 'hr','img', 'input',
        'keygen', 'link', 'meta', 'param', 'source', 'track', 'wbr'
    ];
    public static function tag($tag,...$attributesMap) {
        if (in_array($tag,self::VOID_TAGS)) {
            return self::tag_void_($tag, $attributesMap);
        } else {
            return self::tag_nonVoid($tag, ... $attributesMap);
        }
    }
    public static function tagN($tag,...$attributesMap) {
        return function ($content) use ($tag, $attributesMap) {
            if (self::isAssociativeArray($content, false)) {
                return self::tagN($tag,self::mergeAttributes(...$attributesMap,...[$content]));
            } else {
                
            }
            return self::isAssociativeArray($content, false)
                ? self::tag($tag, self::mergeAttributes(...$attributesMap, ...[$content]))
                : null;//self::toHtml($tag, $content,...$attributesMap);
        };
    }
    public static function div(...$attributesMap) {
        return self::tag('div')(...$attributesMap);
    }
    public static function html($head,$body,$attributes=['lang'=>'en']) {
        return join("\n",
            [
                '<!DOCTYPE html>',
                self::tag('html')([$head,$body],$attributes),
            ]
        );
    }
    public static function head($title,$charset='utf-8') {
        return self::tag('head')(
                self::tag('meta',["charset"=>$charset]),
                self::tag('title')($title)
        );
    }
    public static function body($attributesMap=[]) {
        return self::tag('body',$attributesMap);
    }
    public static function meta_viewport(
        $content=[
            'initial-scale'=>1.0,
            'maximum-scale'=>1.0,
            'user-scalable'=>'no'
        ]) {
        return self::tag('meta',['name'=>'viewport','content'=>QHtml::joinKeyedArray($content,"=",",")]);
    }
    //
    private static function tag_nonVoid_($content, $attributesMap) {
        $firstElement=$content[0];
        if (self::isAssociativeArray($firstElement, false)) {
            $allAttributes=self::mergeAttributes(...$attributesMap, ...$content);
            
        } else {
            $allAttributes=self::mergeAttributes(
                ...$attributesMap,
                ...self::removeFirstElement($content)
            );
            if (!isset($allAttributes['_'])) $allAttributes['_']=[];
            array_push($allAttributes['_'], $firstElement);
        }     
        return $allAttributes;
    }
    private static function tag_nonVoid($tag, ... $attributesMap) {
        return function (...$content) use ($tag, $attributesMap) {
            if ($content==null || $content[0]==null) return QHtml::nonVoidTag($tag, '',$attributesMap);
            $last=array_pop($content);
            if ($content!=null && is_bool($last) && $last) {
                $allAttributes=self::tag_nonVoid_($content,$attributesMap);
                return self::tag_nonVoid($tag,$allAttributes);
            } else {
                array_push($content,$last);
                $allAttributes=self::tag_nonVoid_($content,$attributesMap);
                if (isset($allAttributes['_'])) {
                    $content=self::flatten($allAttributes['_']);
                    unset($allAttributes['_']);
                    return QHtml::nonVoidTag($tag,$content,$allAttributes);
                } else {
                    return self::tag_nonVoid($tag,$allAttributes);
                }
            }
            
        };
    }
    private static function tag_void_($tag, $allAttributes) {
        if ($allAttributes==null) {
            return QHtml::voidTag($tag);
        } else {
            $last = array_pop($allAttributes);
            if (is_bool($last) && $last) {
                return self::tag_void($tag, ...$allAttributes);
            } else {
                array_push($allAttributes, $last);
                return QHtml::voidTag($tag,self::mergeAttributes(...$allAttributes));
            }
        }        
    }
    private static function tag_void($tag, ...$attributesMap) {
        // $attributesMap can not be strictly null by construction, at minimum empty
        return function (...$additionalAttributes) use($tag,$attributesMap) {
            $allAttributes=self::mergeAttributes($attributesMap,$additionalAttributes);
            return self::tag_void_($tag, $allAttributes);
        };
    }
    public static function mergeAttributes(...$attributeMaps) {
        $css=['style','class'];
        $delimiter=[';',' ',''];
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
    private static function removeFirstElement($array) {
        array_shift($array);
        return $array;
    }
    private static function isAssociativeArray($array, $weakNullIncluded) {
        if ($array==null) return $weakNullIncluded;
        if (is_array($array))
            // check only is the first element has a key string
            foreach ($array as $k=>$v) return is_string($k);
        else
            return false;
    }
    private static function flatten(array $a) {
        $r = array();
        array_walk_recursive($a, function($a) use (&$r) { $r[] = $a; });
        return $r;
    }
}