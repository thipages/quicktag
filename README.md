# quicktag
Quick Html tags builder

### Installation
**composer** require thipages\quicktag OR use the single php file **quicktag.php**

### Usage of QTag class
#### Through the following static methods
```php
    // Main API
    tag     ($tag, $content='', ...$attributeMaps)
    voidTag ($tag, ...$attributeMaps)

    // Helper for tag repetition
    tagN    ($tag, $contents, ... $attributeMaps)

    // Tag shortcuts
    html    ($content, $attributes=['lang'=>'en'])
    head    ($content,$title,$charset='utf-8')
    body    ($content)
    div     ($content='',...$attributeMap1=[])
```

#### Examples
```php
$html=QTag::tag('div','Hello QTag',['style'=>'color:blue']);
/* <div style="color:blue">Hello QTag</div> */

$html=QTag::voidTag('input', ['type'=>'num','min'=>2]);
/* <input type="num" min="2" /> */

$blue=['style'=>'color:blue'];
$html=QTag::tag('div','Merged with static attributes',$blue,['padding'=>'3px']);
/* <div style="color:blue;padding:3px">Merging with static attributes</div> */

$html=QTag::tag('div',[
    QTag::tag('div','Hello'),
    QTag::tag('div','QTag')
], 'title'=>'Hello QTag);
/*
    <div title="Hello QTag">
        <div>Hello</div>
        <div>QTag</div>
    </div>
*/

$html=QTag::tagN('div',[1,2]);
/* <div>1</div><div>2</div> */

$html=QTag::div("shortcut");
/* <div>shortcut</div> */
```

### Usage of QT
to be written
