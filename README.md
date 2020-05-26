# quicktag
Quick Html tags builder

### Installation
**composer** require thipages\quicktag


### Usage of QTag class
#### Basic usage
Maps are associative arrays mapping tags attributes
```php
    // *************
    // CONTENT TAGS
    // *************
    QTag::tag ($tag, ...$map)($content) : String
    QTag::tag ($tag, ...$map1)($content,$map2]) : String
    // *************
    // VOID TAGS
    // *************
    QTag::tag ($tag, ...$map):String
```
##### Examples
```php
$blue=['style'=>'color:blue'];

$html=QTag::tag('span',$blue)('Hello QTag');
/* <span style="color:blue">Hello QTag</span> */

$html=QTag::tag('input', ['type'=>'num','min'=>2]);
/* <input type="num" min="2" /> */
```

<details>
 <summary>Templating usage - Content tags</summary>
    
 ```php
    QTag::tag ($tag, ...$map1)[($content, ...$map2, true)]n($content, ...$mapN) : String
```
Examples
```php
$blue=['style'=>'color:blue'];

$template=QTag::tag('span',$blue)('Hello QTag', true);
$html=$template('...and more");
/* <span style="color:blue">Hello QTag...and more</span> */
```
</details>


<details>
 <summary>Templating usage - Void tags</summary>
    
```php
    QTag::tag ($tag, ...$map1, true)[(...$map2, true)]n(...$mapN) : String
```
##### Examples
```php
$blue=['style'=>'color:blue'];
$min=['min'=>2];

$template=QTag::tag('input',$blue, true);
$html=$template($min);
/* <input style="color:blue" min="2"/> */
```
</details>
