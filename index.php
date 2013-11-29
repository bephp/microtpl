<?php

require_once 'microtpl.php';

$tpl = new MicroTpl();
$tpl->title = 'MicroTpl';
$tpl->messages = array(
  'Hello, Earth',
  'We confiscates this planet.'
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
    <p>{value}</p>
    {/messages}
  </body>
</html><?php
$t = ob_get_clean();
echo MicroTpl::parse($t), "\n";
$tpl->render($t);
