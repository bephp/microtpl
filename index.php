<?php
require_once 'ndebugger.php';
NDebugger::enable();

require_once 'microtpl.php';

$tpl = new MicroTpl();
$tpl->title = 'MicroTpl';
$tpl->text = 'Hello, world.';

ob_start();

?><!DOCTYPE html>
<html>
  <head>
    <title>{title}</title>
  </head>
  <body>
    <h1>{title}</h1>
    <p>{text}</p>
  </body>
</html><?php

$tpl->render(ob_get_clean());
