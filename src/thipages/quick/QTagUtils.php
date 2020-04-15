<?php
namespace thipages\quick;
class QTagUtils {
    public static function defaultToArray(&$a,$forceArray=false) {
        if ($a==null) {
            $a=[];
        } else if ($forceArray && !is_array($a)) {
            $a=[$a];
        }
    }
    public static function isAssociativeArray($arr) {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}