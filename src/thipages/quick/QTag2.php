<?php
namespace thipages\quick;
class QTag2 {
    const VOID_TAGS=[
        'area', 'base', 'br', 'col', 'command', 'embed', 'hr','img', 'input',
        'keygen', 'link', 'meta', 'param', 'source', 'track', 'wbr'
    ];
    public static function tag($tag,...$attributesMap) {
        if (in_array($tag,self::VOID_TAGS)) {
            if ($attributesMap==null) {
                return self::toHtml($tag,'');
            } else {
                $last=array_pop($attributesMap);
                if (is_bool($last) && $last) {
                    return self::tag_void($tag, ...$attributesMap);
                } else {
                    array_push($attributesMap,$last);
                    return self::toHtml($tag, '',...$attributesMap);
                }
            }
        } else {
            return self::tag_nonVoid($tag, ... $attributesMap);
        }
    }
    public static function tagN($tag,...$attributesMap) {
        return function ($content) use ($tag, $attributesMap) {
            if (self::isAssociativeArray($content, false)) {
                return self::tagN($tag,QTagUtils::mergeAttributes(...$attributesMap,...[$content]));
            } else {
                
            }
            return self::isAssociativeArray($content, false)
                ? self::tag($tag, QTagUtils::mergeAttributes(...$attributesMap, ...[$content]))
                : self::toHtml($tag, $content,...$attributesMap);
        };
    }
    public static function div(...$attributesMap) {
        return self::tag('div',...$attributesMap);
    }
    public static function html($attributes=['lang'=>'en']) {
        return join("\n",
            ['<!DOCTYPE html>',self::tag('html',$attributes)]
        );
    }
    // <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    /*public static function head($title,$charset='utf-8') {
        return self::tag('head',
            [
                "<meta charset=\"$charset\">",
                "<title>$title</title>"
            ]
        );
    }*/
    public static function body($attributesMap=[]) {
        return self::tag('body',$attributesMap);
    }
    private static function isAssociativeArray($array, $includesAllExceptions) {
        if ($array==null) return $includesAllExceptions;
        if (is_array($array))
            foreach ($array as $k=>$v) return is_string($k);
        else
            return false;
    }
    private static function toHtml($tag='div', $content='', ...$attributesMap) {
        $c= is_array($content)?join('',$content):$content;
        return QTagUtils::tag($tag,$c,QTagUtils::mergeAttributes(...$attributesMap));
    }
    private static function tag_nonVoid($tag, ... $attributesMap) {
        return function (...$content) use ($tag, $attributesMap) {
            if ($content[0]==null) return self::toHtml($tag, '',...$attributesMap);
            return is_scalar($content[0])
                ? QTagUtils::tag(
                    $tag,
                    $content[0],
                    QTagUtils::mergeAttributes(
                        ...$attributesMap,
                        ...self::removeFirstElement($content))
                ) : (
                self::isAssociativeArray($content[0], false)
                    ? self::tag($tag, QTagUtils::mergeAttributes(...$attributesMap, ...$content))
                    : self::toHtml($tag,$content[0],QTagUtils::mergeAttributes(
                    ...$attributesMap,
                    ...self::removeFirstElement($content))
                ));
        };
    }
    private static function tag_void($tag, ...$attributesMap) {
        return function (...$content) use($tag,$attributesMap) {
            if ($attributesMap==null) {
                return self::toHtml($tag,'');
            } else {
                $last = array_pop($content);
                if (is_bool($last) && $last) {
                    return self::tag_void($tag, ...$attributesMap, ...$content);
                } else {
                    array_push($content, $last);
                    return self::toHtml($tag,'', ...$attributesMap, ...$content);
                }
            }
        };
    }
    private static function removeFirstElement($array) {
        array_shift($array);
        return $array;
    }

}