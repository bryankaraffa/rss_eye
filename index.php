<?php
include_once('rss_eye.php');
include_once('config.php');

$amazon = new rss_eye('http://status.aws.amazon.com/rss/all.rss', '/tmp/');

// SlackMsg() Function
// (string) $message - message to be passed to Slack
// (string) $room - #room or @user that you want to message
// (string) $icon - You can set up custom emoji icons to use with each message
// (string) $config['slackIncomingWebhookUrl'] - Slack API Incoming Webhook URL (required)
function slackmsg($message, $room = "@bryan.karaffa", $icon = "") {
    global $config;
    $room = ($room) ? $room : "@bryan.karaffa";
        $data = "payload=" . json_encode(array(
                "username"      =>  "AWS-Status-Bot",
                "channel"       =>  $room,
                "text"          =>  urlencode($message),
                "icon_emoji"    =>  $icon
            ));
        // You can get your webhook endpoint from your Slack settings
        $ch = curl_init($config['slackIncomingWebhookUrl']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        curl_close($ch);
}

foreach($amazon->items['new'] as $item) {
  slackmsg('[AWS Status Alert] ['.$item->pubDate.'] *'.$item->title.'*  _ '.$item->description.' _', '@bryan.karaffa', ':bangbang:');
  print(json_encode($item));
}
?>
