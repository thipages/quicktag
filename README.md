# quicktag
Quick Html tags builder

### Installation
**composer** require thipages\quicktag OR use the single php file **quicktag.php**


### Usage of QTag class
#### Through the following static methods
```php
    // Basic API
    tag      ($tag, ...$attributeMaps)($content) : String
    emptyTag ($tag, ...$attributeMaps) : String
    // Templating
    not yet documented

```

#### Examples
```php
$html=QTag::tag('div',['style'=>'color:blue'])('Hello QTag');
/* <div style="color:blue">Hello QTag</div> */

$html=QTag::voidTag('input', ['type'=>'num','min'=>2]);
/* <input type="num" min="2" /> */
```
