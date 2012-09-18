<?php
require_once 'ndebugger.php';
NDebugger::enable();

require_once 'microtpl.php';

$tpl = new MicroTpl();
$tpl->title = 'MicroTpl';
$tpl->messages = array(
  array('message' => 'Hello, Earth'),
  array('message' => 'We confiscates this planet.')
);

ob_start();

?><!DOCTYPE html>
<html>
  <head>
    <title>{title}</title>
  </head>
  <body>
    <h1>{title}</h1>
    {@messages}
    <p>{message}</p>
    {/messages}
  </body>
</html><?php

$tpl->render(ob_get_clean());
