# MicroTpl

MicroTpl is small templating system for PHP.

## Example
### index.tpl.php

	<!DOCTYPE html>
	<html>
	  <head>
		<title class="title" t:content="$title"><h1>title h1 place holder </h1></title>
	  </head>
	  <body>
		<h1 t:content="$title">title place holder</h1>
		<hr/>
		<div t:if="isset($messages)">
			<p t:foreach="$messages as $key => $message" t:content="$message">message1 place holder</p>
			<p t:replace="">message2 place holder</p>
		</div>
	  </body>
	</html>

### index.php

	<?php
	include "MicroTpl.php";

	$t = new MicroTpl();
	$t->title = 'Hello Micro Template';
	$t->messages = array('message 1', 'message 2');
	$t->parse(file_get_contents('index.html'));
    ?>

## Output

	<html>
	  <head>
		<title class="title">Hello Micro Template</title>
	  </head>
	  <body>
		<h1>Hello Micro Template</h1>
			<hr></hr>
		<div>
			<p>message 1</p>
	<p>message 2</p>
		</div>
	  </body>
	</html>
	
## Output

    t:content="$title"
	t:if="isset($messages)"	
	t:foreach="$messages as $key => $message"
	t:replace=""
