<?php

class rss_eye {
  var $url;
  var $hashMethod = 'md5';
  var $tmpDir = '/tmp/';
  var $items = array(
    "new" => Array(),
    "cached" => Array(),
  );
  var $feed;

  function rss_eye($url) {
    $this->url = $url;
  }

  function getFeed() {
    $feed = file_get_contents($this->url);
    $xml = simplexml_load_string($feed);
    $this->feed = $xml;
    return $this->feed;
  }

  function getFeedJson() {
    $this->getFeed();
    return json_encode($this->feed);
  }

  function check() {
    $this->getFeed();
    $xml = $this->feed;
    $items = Array();

    $i=0;
    while (!empty($xml->channel->item[$i]) && !is_null($xml->channel->item[$i]->title)) {

    	// Generate Hash values
      $rssUrlHash = hash($this->hashMethod, $this->url);
    	$pubDateHash = hash($this->hashMethod, $xml->channel->item[$i]->pubDate);
    	$titleHash = hash($this->hashMethod, $xml->channel->item[$i]->title);
      // Compile unique identifier for this RSS item
    	$itemHashUUID = "$rssUrlHash.$pubDateHash.$titleHash";
      // Convert to JSON for cache storage
      $itemJSON = json_encode($xml->channel->item[$i]);

    	// Unneccessary for hash checks, but useful for other things
    	$link = $xml->channel->item[$i]->link;
    	$description = $xml->channel->item[$i]->description;
    	$title = $xml->channel->item[$i]->title;
    	$pubDate = $xml->channel->item[$i]->pubDate;

    	// Use file-cache to see if they exists
    	if (!file_exists($this->tmpDir.$itemHashUUID)) {
           // RSS Item is either new or has not been cached before

           // Cache the item and contents for later reference
    	     $fp = fopen($this->tmpDir.$itemHashUUID, 'w');
           fwrite($fp, $itemJSON);
           fclose($fp);

           array_push($this->items['new'],$xml->channel->item[$i]);

    	}
    	else {
    	    // RSS Item has already been cached.

          array_push($this->items['cached'],$xml->channel->item[$i]);


      }

      // Increase while-loop counter
      $i++;
    } // close while loop
  } // close check();

}
