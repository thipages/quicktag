<?php
use thipages\quick\QTag;
class Tests {
    public static function textarea($value) {
        return QTag::tag(
            'textarea', $value,
            ['style' => 'border-style:none;width:300px;overflow:hidden', 'readonly' => true]
        );
    }
    public static function getOutput($classOrList) {
        if (!is_array($classOrList)) $classOrList=[$classOrList];
        $html = [];
        foreach ($classOrList as $test) {
            $res = [];
            foreach ($test::tests() as $dataset) {
                $res[] = [
                    $dataset[2],
                    $dataset[0] === $dataset[1] ? "OK" : "NOK",
                    self::textarea($dataset[0]),
                    self::textarea($dataset[1]),
                    $dataset[1]
                ];
            }
            $html[] = QTag::tag('h3', $test);
            $html[] = GenericTable::helper(['Descrition', 'Result', 'Actual', 'Expected', 'Html'], $res, ['border' => 1]);
        }
        return join('',$html);
    }
}