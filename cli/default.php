<?php

$log->addDebug("{$url_parts['host']} not found. Default.");

$log->addInfo("Title of the page is: " . html_entity_decode($html->find("head title", 0)->plaintext));
