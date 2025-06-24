<?php
if (!isset($_GET['url'])) exit;
$url = $_GET['url'];
if (!preg_match('/^https?:\/\//', $url)) exit; // Only allow http/https
$headers = get_headers($url, 1);
$contentType = isset($headers['Content-Type']) ? $headers['Content-Type'] : 'image/png';
header('Content-Type: ' . $contentType);
header('Access-Control-Allow-Origin: *');
readfile($url); 