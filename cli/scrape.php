<?php

$urls = explode(' ', $url);

foreach($urls AS $url){
	$html = \SimpleHtmlDom\file_get_html($url);
	$url_parts = parse_url($url);

	if(!isset($url_parts['host'])) {
		$log->addError("The provided URL does not have a host.");
		exit;
	}
	$log->addInfo("Parsing host {$url_parts['host']}");
	switch($url_parts['host']) {
		case "www.last.fm":
			$url_parts['host'] = mb_substr($url_parts['host'], 4);
		case "last.fm":
		case "slashdot.org":
			$sub_controller = $url_parts['host'];
			break;
		default:
			$sub_controller = "default";
			break;
	}
	$sub_controller_file = __DIR__ . '/' . $sub_controller . '.php';
	if(is_file($sub_controller_file) && is_readable($sub_controller_file)) {
		$log->addDebug("Loading subcontroller $sub_controller for {$url_parts['host']}");
		include($sub_controller_file);
	} else {
		$log->addError("Whatt?? Something went wrong trying to process that URL $url");
		exit;
	}
}

