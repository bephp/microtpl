<?php
include "MicroTpl.php";
/*
$t = new MicroTpl();
$t->title = 'Hello Micro Template';
$t->messages = array('message 1', 'message 2');
echo $t->parse(file_get_contents('index.html'));
echo $t->parse(file_get_contents('layout.html'));
*/
MicroTpl::render('index.html', array('title' => 'Hello Micro Template', 'messages' => array('message 1', 'message 2')), 'layout.html');