# quicktag
Quick Html tags builder

### Installation
**composer** require thipages\quicktag OR use the single php file **quicktag.php**

### Usage of QTag class
#### Through the following static methods
```php
    tag     ($tag, $content='', $attributeMap1=[],$attributeMap2=[])
    voidTag ($tag, $attributeMap=[])
    tagN    ($tag, $contents, $attributeMap1=[],$attributeMap2=[]) // an helper for tag repetition
    // shortcuts
    html    ($content, $attributes=['lang'=>'en'])
    head    ($content,$title,$charset='utf-8')
    body    ($content)
    div     ($content='',$attributeMap1=[],$attributeMap2=[])
```

#### Examples
```php
$html=QTag::tag('div','Hello QTag',['style'=>'color:blue']);
/* <div style="color:blue">Hello QTag</div> */

$blue=['style'=>'color:blue'];
$html=QTag::tag('div','Merged with static attributes',$blue,['padding'=>'3px']);
/* <div style="color:blue;padding:3px">Merging with static attributes</div> */

$html=QTag::tag('div',[
    QTag::tag('div','Hello'),
    QTag::tag('div','QTag', ['style'=>'color:green'])
], 'title'=>'Hello QTag);
/*
    <div title="Hello QTag">
        <div>Hello</div>
        <div style="color:green">QTag</div>
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
