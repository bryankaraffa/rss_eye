<?php
include_once('rss_eye.php');


// New Amazon Status Updates:
print '<h1>New Amazon Status Updates:</h1>';
$amazon = new rss_eye('http://status.aws.amazon.com/rss/all.rss', './tmp/');
print_r($amazon->items['new']);

// reddit.com/r/Jeep
print "<h1>New /r/Jeep Items:</h1>";
$r_jeep = new rss_eye('http://www.reddit.com/r/Jeep/new.rss', './tmp/');
print_r($r_jeep->items['new']);


// Gizmodo
print "<h1>New Gizmodo Items:</h1>";
$giz = new rss_eye('http://feeds.gawker.com/gizmodo/full.xml', './tmp/');
print_r($giz->items['new']);
?>
