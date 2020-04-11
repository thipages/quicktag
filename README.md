# quicktag
Quick Html tags builder

### Installation
**composer** require thipages\quicktag OR use the single php file **quicktag.php**

### Usage of QTag class
#### Through 4 static methods
```php
    tag     ($tag, $content='', $attributeMap=[])
    voidTag ($tag, $attributeMap=[])
    tagN    ($tag, $contents, $attributeMap) // a shortcut for tag repetition
    div     ($content='',$attributeMap=[])   // a shortcut div builder
```

#### Examples
```php
$html=QTag::tag('div','Hello QTag',['style'=>'color:blue;']);
/* <div style="color:blue;">Hello QTag</div> */

$html=QTag::tag('div',[
    QTag::tag('div','Hello'),
    QTag::tag('div','QTag', ['style'=>'color:green;'])
], 'title'=>'Hello QTag);
/*
    <div title="Hello QTag">
        <div>Hello</div>
        <div style="color:green;">QTag</div>
    </div>
*/

$html=QTag::voidTag('input', ['type'=>'num','min'=>2]);
/* <input type="num" min="2" /> */

$html=QTag::tagN('div',[1,2]);
/* <div>1</div><div>2</div> */

$html=QTag::div("shortcut");
/* <div>shortcut</div> */
```

### Usage of QT
to be written
