<?php
include "MicroTpl.php";

$t = new MicroTpl();
$t->title = 'Hello Micro Template';
$t->messages = array('message 1', 'message 2');
$t->parse(file_get_contents('index.html'));
