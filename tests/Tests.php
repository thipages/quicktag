<?php
use thipages\quick\QTag;
use thipages\quick\QTable;
class Tests {
    public static function textarea($value) {
        return QTag::tag(
            'textarea', $value,
            ['style' => 'border-style:none;width:300px;overflow:hidden', 'readonly' => true]
        );
    }
    public static function getOutput($classOrList, $idFilter=null) {
        if (!is_array($classOrList)) $classOrList=[$classOrList];
        $html = [];
        if ($idFilter!==null) $classOrList=[$classOrList[$idFilter[0]]];
        foreach ($classOrList as $test) {
            $res = [];
            $index=0;
            foreach ($test::tests() as $dataset) {
                if ($idFilter===null || ($idFilter!==null && $idFilter[1]===$index)) {
                    $res[] = [
                        $dataset[2],
                        $dataset[0] === $dataset[1] ? "OK" : "NOK",
                        self::textarea($dataset[0]),
                        self::textarea($dataset[1]),
                        $dataset[1]
                    ];
                }
                $index++;
            }
            $html[] = QTag::tag('h3', $test);
            $html[] = QTable::create(['Description', 'Result', 'Actual', 'Expected', 'Html'], $res, ['border' => 1]);
        }
        return join('',$html);
    }
}