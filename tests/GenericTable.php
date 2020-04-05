<?php
use thipages\quick\QTag;
class GenericTable {
    private $html;
    public function __construct($headers, $cells, $tableAttributes=[]) {
        $html_header=[];
        $html_rows=[];
        foreach ($cells as $cell) {
            $c=[];
            if (!is_array($cell)) $cell=[$cell];
            $colNum=0;
            foreach ($cell as $col) {
                $c[]=QTag::tag('td',$col);
                $colNum++;
            }
            $html_rows[]=QTag::tag('tr',join('',$c));
        }
        if ($headers) foreach ($headers as $header) $html_header[]=QTag::tag('th',$header,['style'=>'padding:3px']);
        $this->html= QTag::tag(
            'table',
            join('',$html_header)
            .join('',$html_rows),
            $tableAttributes
        );
    }
    public function getHTML() {
        return $this->html;
    }
    public static function helper($headers,$rows, $tableAttributes=[]) {
        return (new self($headers,$rows, $tableAttributes))->getHtml();
    }
}