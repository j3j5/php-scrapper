<?php

/**
 *  Scrape the last articles from the last.fm forum
 */

// Find all article blocks
$authors_names = array();
$dates = array();
foreach($html->find('table tr') as $post) {
	if(!empty($post) && !empty($post->find('.lastPost a', 0))) {
		$authors_names[] = $post->find('.lastPost a', 0)->plaintext;
		$dates[] = $post->find('.lastPost small a', 0)->plaintext;
	}
}

$log->addInfo(count($authors_names) . " posts found, retrieving authors info.");

$authors = array();
foreach($authors_names AS $index => $author) {
	$url_auth = 'http://www.last.fm/user/' .$author;
	$html_profile = @\SimpleHtmlDom\file_get_html($url_auth);	// The function throws PHP warnings on HTTP errors like 404 or 401, silence those.
	if(!empty($html_profile)) {
		$staff = !empty(trim($html_profile->find('#content div.badgeAvatar', 0))) ? trim($html_profile->find('#content div.badgeAvatar', 0)->plaintext) : 'false_prof';
		$staff = (empty($staff) OR $staff == "subscriber") ? 'false' : $staff;
		$authors[$author] = array('role' => $staff, 'post_date' => $dates[$index]);
	} else {
		$authors[$author] = array('role' => 'user does not exist', 'post_date' => $dates[$index]);
	}
}

print_r($authors);
