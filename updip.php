<?php
$zoneid="YOUR_ZONE_ID";
$recordid="YOUR_RECORD_ID";
$apitoken='YOUR_API_TOKEN';
$dnsrecord='home.domain.tld';
$routerip='192.168.178.1';

if($_SERVER['REMOTE_ADDR'] != $routerip) {
        echo "<h1>Access denied</h1>";
        exit();
}

$ip = $_GET['ip'];


$header = [
        "Content-Type: application/json",
        "Authorization: Bearer $apitoken"
];
$body = array(
        'type' => 'A',
        'name' => "$dnsrecord",
        'content' => "$ip",
        'proxied' => false,
        'ttl' => '3600',

);

$cf = curl_init();
curl_setopt($cf, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cf, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($cf, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/$zoneid/dns_records/$recordid");
curl_setopt($cf, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($cf, CURLOPT_HTTPHEADER, $header);
curl_setopt($cf, CURLOPT_POSTFIELDS, json_encode($body));

$result = curl_exec($cf);
echo "<pre>$result</pre>";

?>