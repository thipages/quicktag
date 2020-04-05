# quicktag
Quick Html tags builder

## Installation
composer thipages\quicktag

OR

use the single php file quickTag.php

## Usage of QTag
```php
QTag::tag('div','Hello QTag',['style'=>'color:blue;']);
/* <div style="color:blue;">Hello QTag</div> */

QTag::tag('div',[
    QTag::tag('div','Hello'),
    QTag::tag('div','QTag', ['style'=>'color:green;'])
], 'title'=>'Hello QTag);
/*
    <div title="Hello QTag">
        <div>Hello</div>
        <div style="color:green;">QTag</div>
    </div>
*/
```

## Usage of QT
to be written
