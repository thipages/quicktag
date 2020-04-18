<?php
namespace thipages\quick;
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