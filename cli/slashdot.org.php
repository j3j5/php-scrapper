<?php

/**
 *  Example scrapping slashdot. More at http://simplehtmldom.sourceforge.net/
 */

	// Find all article blocks
	foreach($html->find('div.article') as $article) {
		$item['title']     = $article->find('div.title', 0)->plaintext;
		$item['intro']    = $article->find('div.intro', 0)->plaintext;
		$item['details'] = $article->find('div.details', 0)->plaintext;
		$articles[] = $item;
	}

	$log->addInfo(print_r($articles, TRUE));
