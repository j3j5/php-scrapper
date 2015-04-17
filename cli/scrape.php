<?php


$html = \SimpleHtmlDom\file_get_html($url);

$url_parts = parse_url($url);

if(!isset($url_parts['host'])) {
	$log->addError("The provided URL does not have a host.");
	exit;
}
$log->addInfo("Parsing host {$url_parts['host']}");
switch($url_parts['host']) {
	case "last.fm":
	case "slashdot.org":
	default:
		$sub_controller_file = __DIR__ . '/' . $url_parts['host'] . '.php';
		if(is_file($sub_controller_file) && is_readable($sub_controller_file)) {
			$log->addDebug("Loading subcontroller for {$url_parts['host']}");
			include($sub_controller_file);
			exit;
		}
}
$log->addDebug("{$url_parts['host']} not found. Default.");

$log->addInfo("Title of the page is: " . $html->find("head title", 0)->plaintext);
