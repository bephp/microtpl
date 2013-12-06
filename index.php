<?php
include "MicroTpl.php";
/*
$t = new MicroTpl();
$t->title = 'Hello Micro Template';
$t->messages = array('message 1', 'message 2');
echo $t->parse(file_get_contents('index.html'));
echo $t->parse(file_get_contents('layout.html'));
*/
$content = <<<STRING
small template attribute language implement for PHP (using xml_parse)
small template attribute language implement for PHP (using xml_parse)
small template attribute language implement for PHP (using xml_parse)
small template attribute language implement for PHP (using xml_parse)
small template attribute language implement for PHP (using xml_parse)
small template attribute language implement for PHP (using xml_parse)
small template attribute language implement for PHP (using xml_parse)
small template attribute language implement for PHP (using xml_parse)
small template attribute language implement for PHP (using xml_parse)
small template attribute language implement for PHP (using xml_parse)
small template attribute language implement for PHP (using xml_parse)
small template attribute language implement for PHP (using xml_parse)
small template attribute language implement for PHP (using xml_parse)
small template attribute language implement for PHP (using xml_parse)
small template attribute language implement for PHP (using xml_parse)
STRING
;
MicroTpl::render('index.html', array(
	'title' => 'Hello Micro Template', 
	'messages' => array(
		array('title' => 'message 1', 'content' => $content),
		array('title' => 'message 2', 'content' => $content),
		array('title' => 'message 3', 'content' => $content),
		array('title' => 'message 4', 'content' => $content),
		array('title' => 'message 5', 'content' => $content),
		array('title' => 'message 6', 'content' => $content),
		array('title' => 'message 7', 'content' => $content),
		array('title' => 'message 8', 'content' => $content),
		array('title' => 'message 9', 'content' => $content),
		array('title' => 'message 10', 'content' => $content)
	)
), 'layout.html');