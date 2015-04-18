<?php
use marcushat\RollingCurlX;

	$max_concurrent_requests = 30;
	$curl_settings = array(
		CURLOPT_SSL_VERIFYPEER	=> FALSE,
		CURLOPT_SSL_VERIFYHOST	=> FALSE,
		CURLOPT_FOLLOWLOCATION => TRUE,
		CURLOPT_MAXREDIRS		=> 5,
		CURLOPT_USERAGENT		=> 'Simple PHP web scrapper, I will be good, I promise!',
	);

	$urls = explode(' ', $url);

	$rolling_curl = new RollingCurlX($max_concurrent_requests);
	$log->addDebug("New RollingCurlX created with {$max_concurrent_requests} max concurrent reqs.");
	$rolling_curl->setOptions($curl_settings);

	foreach($urls AS $url){
		$log->addDebug("Adding request for $url");
		$rolling_curl->addRequest($url, NULL, 'process_html', $log);
	}
	$rolling_curl->execute();


	/**
	 * Process all HTML responses
	 *
	 * @return void
	 *
	 * @author Julio Foulquié <jfoulquie@gmail.com>
	 */
	function process_html($response, $url, $request_info, $log, $time) {

		if(empty($response)) {
			$log->addWarning("Response was empty");
			$log->addWarning(print_r($request_info, TRUE));
			return;
		}

		$html = \SimpleHtmlDom\str_get_html($response);
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
