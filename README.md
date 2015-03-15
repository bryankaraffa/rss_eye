# rss_eye
PHP Class for watching RSS feed and easily knowing which feed are new since the last time they were cached.

# Usage:
First you will need to download rss_eye.php and include it in whatever script you are using.
```php
include_once('/location/to/rss_eye.php');
```

Once you have included the rss_eye Class into your script, you can create a rss_eye Object.  You will want to specify the RSS url here as the first parameter.  You can also specify the cache directory (must be writable) and hash method, but they are not required.
```php
$myObject = new rss_eye('http://status.aws.amazon.com/rss/all.rss', );
```
The rss_eye Object will automatically check and cache the first entries.  By design, the first time run all items will be classified as "new" items.  


### Show New Amazon Status Updates:
Here is a fully working example to display only new Amazon Web Service status items from their status [RSS feed](http://status.aws.amazon.com/rss/all.rss).  The first run will print all items.  When the page is refreshed [or the second time the script is run] all items will have been cached and no items should appear.  That is of course there was a new item posted to the RSS feed since the previous rss_eye check which is the whole intention of this script.  It can very easily be setup on as a scheduled task and be used to monitor multiple RSS feed very easily. 

```php
<?php
include_once('rss_eye.php');

// New Amazon Status Updates:
print '<h1>New Amazon Status Updates:</h1>';
$amazon = new rss_eye('http://status.aws.amazon.com/rss/all.rss', './tmp/');
print_r($amazon->items['new']);
```
#### You can look at [examples.php](https://github.com/bryankaraffa/rss_eye/blob/master/example.php) as well for more turn-key examples of how to use rss_eye
