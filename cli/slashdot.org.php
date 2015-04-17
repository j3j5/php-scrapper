<?php

/**
 *  Example scrapping slashdot. More at http://simplehtmldom.sourceforge.net/
 */

	// Find all article blocks
	foreach($html->find('article') as $article) {
		if(!empty($article)) {
			$item['title']     = $article->find('h2 a', 0)->plaintext;
			$item['intro']    = $article->find('.body .p', 0)->plaintext;
			$item['details'] = $article->find('header h2 a', 0)->plaintext;
			$articles[] = $item;
		}
	}

	$log->addInfo(print_r($articles, TRUE));
