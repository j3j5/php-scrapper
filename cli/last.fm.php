<?php

/**
 *  Scrape the last articles from the last.fm forum
 */

// Find all article blocks
$authors_names = array();
foreach($html->find('table tr') as $post) {
	if(!empty($post) && !empty($post->find('.lastPost a', 0))) {
		$authors_names[] = $post->find('.threadAuthor a', 0)->plaintext;
	}
}

$authors = array();
foreach($authors_names AS $author) {
	$url_auth = 'http://www.last.fm/user/' .$author;
	$html_profile = \SimpleHtmlDom\file_get_html($url_auth);
// 	$staff = $html_profile->find('#content div.badgeAvatar', 0)->plaintext;
	$staff = !empty($html_profile->find('#content div.badgeAvatar', 0)) ? trim($html_profile->find('#content div.badgeAvatar', 0)->plaintext) : FALSE;
// 	$staff = !empty(trim($html_profile->find('#content div.badgeAvatar', 0))) ? TRUE : FALSE;
	$authors[$author] = empty($staff) ? FALSE : TRUE;
}

var_dump($authors);
