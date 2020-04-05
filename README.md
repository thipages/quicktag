# quicktag
Quick Html tags builder

### Installation
composer require thipages\quicktag OR use the single php file quicktag.php

### Usage of QTag class
#### Through 3 static methods
```php
    tag     ($tag, $content='', $attributeMap=[])
    voidTag ($tag, $attributeMap=[])
    div     ($content='',$attributeMap=[]) // a shortcut div builder
```

#### Examples
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

QTag::voidTag('input', ['type'=>'num','min'=>2]);
/* <input type="num" min="2" /> */

QTag::div("shortcut");
/* <div>shortcut</div> */
```

### Usage of QT
to be written
