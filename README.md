# quicktag
Quick Html tags builder

### Installation
**composer** require thipages\quicktag OR use the single php file **quicktag.php**


### Usage of QTag class
#### Basic usage
Maps are associative arrays mapping tags attributes
```php
    // *************
    // CONTENT TAGS
    // *************
    tag ($tag, ...$map)($content) : String
    tag ($tag, ...$map1)($content,$map2]) : String
    // *************
    // VOID TAGS
    // *************
    tag ($tag, ...$map):String
```
##### Examples
```php
$html=QTag::tag('span',['style'=>'color:blue'])('Hello QTag');
/* <span style="color:blue">Hello QTag</span> */

$html=QTag::voidTag('input', ['type'=>'num','min'=>2]);
/* <input type="num" min="2" /> */
```
#### Templating usage - Content tags
```php
    tag ($tag, ...$map1)[($content, ...$map2, true)]n($content, ...$mapN) : String
```
##### Examples
```php
$blue=['style'=>'color:blue'];
$template=QTag::tag('span',$blue)('Hello QTag', true);
$html=$template('...and more");
/* <span style="color:blue">Hello QTag...and more</span> */

#### Templating usage - Void tags
```php
    tag ($tag, ...$map1, true)[(...$map2, true)]n(...$mapN) : String
```
##### Examples
```php
$min_2=['min'=>2];
$template=QTag::tag('input',$blue, true);
$html=$template($min_2);
/* <input style="color:blue" min="2"/> */
```
